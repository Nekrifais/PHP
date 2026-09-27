#!/usr/bin/env python3
"""Сырые данные о товарах alkojuomat.com с фото через Claude Message Batches API.

Шаги (подробнее в README.md рядом):
  urls     собрать ссылки на товары из карт сайта
  prepare  найти у товаров артикул, название и фото галереи (1024 px)
  submit   отправить товары в Batch API (нужен ANTHROPIC_API_KEY)
  status   показать, как идут пакеты
  results  забрать ответы, разобрать JSON, посчитать стоимость
"""

import argparse
import base64
import csv
import html
import json
import math
import re
import sys
import time
import urllib.error
import urllib.request
from concurrent.futures import ThreadPoolExecutor
from datetime import datetime, timezone
from pathlib import Path

HERE = Path(__file__).resolve().parent
SITE = "https://alkojuomat.com"
USER_AGENT = "Mozilla/5.0 (compatible; alkojuomat-extract/1.0)"
WORKERS = 4
MAX_BATCH_BYTES = 100 * 1024 * 1024  # лимит API — 256 МБ на пакет, держим запас
PROMPT_TOKENS = 1200                 # оценка: текст задания в каждом запросе
ASSUMED_OUTPUT_TOKENS = 3500         # оценка: JSON + рассуждения модели

# Цены Batch API, $ за 1 млн токенов: (вход, выход)
BATCH_PRICES = {
    "claude-opus-5-5": (2.0, 10.0),
    "claude-opus-5": (2.5, 12.5),
    "claude-sonnet-5": (1.0, 5.0),
    "claude-haiku-4-5": (0.5, 2.5),
}


# ---------- общие помощники ----------

def fetch(url, tries=4):
    for attempt in range(tries):
        try:
            req = urllib.request.Request(url, headers={"User-Agent": USER_AGENT})
            with urllib.request.urlopen(req, timeout=60) as resp:
                return resp.read()
        except urllib.error.HTTPError as e:
            if e.code == 404 or attempt == tries - 1:
                raise
        except (urllib.error.URLError, OSError):
            if attempt == tries - 1:
                raise
        time.sleep(2 ** (attempt + 1))  # сайт иногда рвёт соединение — ждём и повторяем


def load_jsonl(path):
    if not path.exists():
        return []
    return [json.loads(line) for line in path.read_text(encoding="utf-8").splitlines() if line.strip()]


def save_jsonl(path, rows):
    path.write_text("".join(json.dumps(r, ensure_ascii=False) + "\n" for r in rows), encoding="utf-8")


def load_json(path, default):
    return json.loads(path.read_text(encoding="utf-8")) if path.exists() else default


def save_json(path, data):
    path.write_text(json.dumps(data, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")


def make_id(text):
    return re.sub(r"[^A-Za-z0-9_-]", "_", text)[:64]


def image_tokens(url):
    # Размер берём из имени файла вида ...-1024x683.webp; без суффикса WordPress
    # отдаёт оригинал, который не больше 1024 px.
    m = re.search(r"-(\d+)x(\d+)\.\w+$", url)
    w, h = (int(m.group(1)), int(m.group(2))) if m else (1024, 1024)
    return min(4784, math.ceil(w / 28) * math.ceil(h / 28))


def media_type(data):
    if data[:4] == b"RIFF" and data[8:12] == b"WEBP":
        return "image/webp"
    if data[:3] == b"\xff\xd8\xff":
        return "image/jpeg"
    if data[:8] == b"\x89PNG\r\n\x1a\n":
        return "image/png"
    if data[:4] == b"GIF8":
        return "image/gif"
    return None


def cost(model, tokens_in, tokens_out):
    price_in, price_out = BATCH_PRICES[model]
    return tokens_in / 1e6 * price_in + tokens_out / 1e6 * price_out


# ---------- urls ----------

def cmd_urls(args):
    index = fetch(f"{SITE}/sitemap_index.xml").decode("utf-8")
    maps = [html.unescape(u) for u in re.findall(r"<loc>([^<]+)</loc>", index) if "/product-sitemap" in u]
    urls = []
    for sitemap in maps:
        xml = fetch(sitemap).decode("utf-8")
        urls += [html.unescape(u) for u in re.findall(r"<loc>([^<]+)</loc>", xml) if "/product/" in u]
    urls = list(dict.fromkeys(urls))
    out = args.out / "urls.txt"
    out.write_text("\n".join(urls) + "\n", encoding="utf-8")
    print(f"Карт сайта с товарами: {len(maps)}, товаров: {len(urls)} → {out}")


# ---------- prepare ----------

def parse_product(url):
    page = fetch(url).decode("utf-8", "replace")
    sku = name = ""
    for block in re.findall(r"<script[^>]*application/ld\+json[^>]*>(.*?)</script>", page, re.S):
        try:
            data = json.loads(block)
        except ValueError:
            continue
        nodes = data.get("@graph", [data]) if isinstance(data, dict) else []
        for node in nodes:
            if isinstance(node, dict) and node.get("@type") == "Product":
                sku = str(node.get("sku") or "")
                name = html.unescape(str(node.get("name") or ""))
    start = page.find('<div class="product-gallery">')
    end = page.find('<div class="product-info', start)
    if start >= 0 and end < 0:
        end = start + 30000
    gallery = page[start:end] if start >= 0 else ""
    images = re.findall(r'data-img="([^"]+)"', gallery)
    if not images:  # у товара одно фото — миниатюр нет
        m = re.search(r'<img[^>]*id="main-product-img"[^>]*>', gallery or page)
        src = re.search(r'\ssrc="([^"]+)"', m.group(0)) if m else None
        images = [src.group(1)] if src else []
    images = list(dict.fromkeys(html.unescape(i) for i in images))
    slug = url.rstrip("/").rsplit("/", 1)[-1]
    return {"custom_id": make_id(sku or slug), "sku": sku, "name": name, "url": url, "images": images}


def safe_parse(url):
    try:
        return parse_product(url)
    except Exception as e:
        return {"url": url, "error": f"{type(e).__name__}: {e}"}


def cmd_prepare(args):
    src = Path(args.urls_file) if args.urls_file else args.out / "urls.txt"
    if not src.exists():
        sys.exit(f"Нет файла {src}: сначала запустите urls или укажите --urls-file.")
    urls = [u.strip() for u in src.read_text(encoding="utf-8").splitlines() if u.strip()]
    urls = urls[args.offset:args.offset + args.limit] if args.limit else urls[args.offset:]
    with ThreadPoolExecutor(max_workers=WORKERS) as pool:
        parsed = list(pool.map(safe_parse, urls))
    products = [p for p in parsed if "error" not in p and p["images"]]
    for p in parsed:
        if "error" in p:
            print(f"  ошибка: {p['url']} — {p['error']}")
        elif not p["images"]:
            print(f"  нет фото: {p['url']}")
    seen = set()
    for p in products:  # одинаковый артикул у разных страниц — делаем id уникальным
        base, n = p["custom_id"], 2
        while p["custom_id"] in seen:
            p["custom_id"], n = make_id(f"{base}_{n}"), n + 1
        seen.add(p["custom_id"])
    save_jsonl(args.out / "products.jsonl", products)

    images = sum(len(p["images"]) for p in products)
    tokens_in = sum(image_tokens(u) for p in products for u in p["images"]) + PROMPT_TOKENS * len(products)
    tokens_out = ASSUMED_OUTPUT_TOKENS * len(products)
    print(f"Товаров: {len(products)} из {len(urls)}, фото: {images} → {args.out / 'products.jsonl'}")
    total = len(load_jsonl_lines(args.out / "urls.txt"))
    print("Оценка стоимости через Batch API (ответ ~{} токенов на товар):".format(ASSUMED_OUTPUT_TOKENS))
    for model in BATCH_PRICES:
        c = cost(model, tokens_in, tokens_out)
        line = f"  {model}: ${c:.2f}"
        if total and products:
            line += f", на все {total} товаров ≈ ${c / len(products) * total:.0f}"
        print(line)


def load_jsonl_lines(path):
    return [l for l in path.read_text(encoding="utf-8").splitlines() if l.strip()] if path.exists() else []


# ---------- submit ----------

def build_request(product, prompt, model, effort):
    content = []
    for url in product["images"]:
        try:
            data = fetch(url)
        except Exception as e:
            print(f"  не скачалось фото {url}: {e}")
            continue
        kind = media_type(data)
        if not kind:
            print(f"  пропущено фото неизвестного формата: {url}")
            continue
        content.append({"type": "text", "text": f"Фото {len(content) // 2 + 1}:"})
        content.append({"type": "image", "source": {
            "type": "base64", "media_type": kind, "data": base64.standard_b64encode(data).decode("ascii")}})
    if not content:
        print(f"  товар пропущен, нет ни одного фото: {product['url']}")
        return None
    text = prompt.replace("%NAME%", product["name"] or "—").replace("%SKU%", product["sku"] or "—")
    content.append({"type": "text", "text": text})
    params = {"model": model, "max_tokens": 16000, "messages": [{"role": "user", "content": content}]}
    if not model.startswith("claude-haiku"):  # Haiku 4.5 не принимает effort
        params["output_config"] = {"effort": effort}
    return {"custom_id": product["custom_id"], "params": params}


def cmd_submit(args):
    batches_path = args.out / "batches.json"
    batches = load_json(batches_path, [])
    if any(not b.get("collected") for b in batches) and not args.force:
        sys.exit("Есть пакеты, ответы которых ещё не забраны: сначала status и results (или --force).")
    done = {r["custom_id"] for r in load_jsonl(args.out / "results.jsonl") if r.get("data") is not None}
    todo = [p for p in load_jsonl(args.out / "products.jsonl") if p["custom_id"] not in done]
    if not todo:
        sys.exit("Нечего отправлять: все товары из products.jsonl уже обработаны.")
    prompt = (HERE / "prompt.txt").read_text(encoding="utf-8")

    client = None
    if not args.dry_run:
        import anthropic
        client = anthropic.Anthropic()

    def send(chunk, size):
        if args.dry_run:
            print(f"[проверка] пакет: {len(chunk)} товаров, {size / 1e6:.1f} МБ — не отправлен")
            return
        batch = client.messages.batches.create(requests=chunk)
        batches.append({"id": batch.id, "model": args.model, "effort": args.effort,
                        "custom_ids": [r["custom_id"] for r in chunk],
                        "created": datetime.now(timezone.utc).isoformat(timespec="seconds"),
                        "collected": False})
        save_json(batches_path, batches)
        print(f"Отправлен пакет {batch.id}: {len(chunk)} товаров, {size / 1e6:.1f} МБ")

    chunk, size = [], 0
    with ThreadPoolExecutor(max_workers=WORKERS) as pool:
        for group_start in range(0, len(todo), 50):  # качаем фото группами, чтобы не держать всё в памяти
            group = todo[group_start:group_start + 50]
            for req in pool.map(lambda p: build_request(p, prompt, args.model, args.effort), group):
                if req is None:
                    continue
                n = len(json.dumps(req))
                if chunk and size + n > MAX_BATCH_BYTES:
                    send(chunk, size)
                    chunk, size = [], 0
                chunk.append(req)
                size += n
            print(f"  подготовлено {min(group_start + 50, len(todo))} из {len(todo)}")
    if chunk:
        send(chunk, size)
    if not args.dry_run:
        print("Готово. Обычно пакет обрабатывается до часа (максимум 24 ч). Проверка: status, затем results.")


# ---------- status ----------

def cmd_status(args):
    import anthropic
    client = anthropic.Anthropic()
    batches = load_json(args.out / "batches.json", [])
    if not batches:
        print("Пакетов пока нет.")
    for b in batches:
        info = client.messages.batches.retrieve(b["id"])
        c = info.request_counts
        mark = " (ответы забраны)" if b.get("collected") else ""
        print(f"{b['id']}: {info.processing_status}{mark} — в работе {c.processing}, готово {c.succeeded}, "
              f"ошибок {c.errored}, отменено {c.canceled}, истекло {c.expired}")


# ---------- results ----------

def parse_json(text):
    t = re.sub(r"^```(?:json)?\s*|\s*```$", "", text.strip())
    for candidate in (t, t[t.find("{"):t.rfind("}") + 1]):
        try:
            return json.loads(candidate)
        except ValueError:
            continue
    return None


def cmd_results(args):
    import anthropic
    client = anthropic.Anthropic()
    products = {p["custom_id"]: p for p in load_jsonl(args.out / "products.jsonl")}
    batches_path = args.out / "batches.json"
    batches = load_json(batches_path, [])
    records = {r["custom_id"]: r for r in load_jsonl(args.out / "results.jsonl")}

    for b in batches:
        if b.get("collected"):
            continue
        info = client.messages.batches.retrieve(b["id"])
        if info.processing_status != "ended":
            print(f"{b['id']}: ещё не готов ({info.processing_status})")
            continue
        for res in client.messages.batches.results(b["id"]):
            rec = dict(products.get(res.custom_id, {"custom_id": res.custom_id}))
            rec["model"] = b["model"]
            if res.result.type == "succeeded":
                msg = res.result.message
                text = "".join(block.text for block in msg.content if block.type == "text")
                u = msg.usage
                rec["usage"] = {
                    "input": u.input_tokens + (u.cache_creation_input_tokens or 0) + (u.cache_read_input_tokens or 0),
                    "output": u.output_tokens,
                }
                rec["stop_reason"] = msg.stop_reason
                rec["data"] = parse_json(text) if msg.stop_reason == "end_turn" else None
                if rec["data"] is None:
                    rec["raw"] = text
            else:
                rec["data"] = None
                err = getattr(getattr(res.result, "error", None), "error", None)
                rec["error"] = f"{res.result.type}: {getattr(err, 'type', '')} {getattr(err, 'message', '')}".strip()
            old = records.get(res.custom_id)
            if old and old.get("data") is not None and rec["data"] is None:
                continue  # не затираем удачный ответ неудачным
            records[res.custom_id] = rec
        b["collected"] = True
        save_json(batches_path, batches)

    rows = list(records.values())
    save_jsonl(args.out / "results.jsonl", rows)
    write_csv(args.out / "results.csv", rows)

    ok = [r for r in rows if r.get("data") is not None]
    failed = [r for r in rows if r.get("data") is None]
    used = [r for r in rows if r.get("usage")]
    tokens_in = sum(r["usage"]["input"] for r in used)
    tokens_out = sum(r["usage"]["output"] for r in used)
    total_cost = sum(cost(r["model"], r["usage"]["input"], r["usage"]["output"]) for r in used)
    print(f"Готово: {len(ok)}, с ошибками: {len(failed)} → {args.out / 'results.jsonl'}, {args.out / 'results.csv'}")
    for r in failed:
        print(f"  {r['custom_id']}: {r.get('error') or 'stop_reason=' + str(r.get('stop_reason'))}")
    if used:
        print(f"Токены: вход {tokens_in:,}, выход {tokens_out:,} (с рассуждениями). "
              f"Стоимость: ${total_cost:.2f}, на товар ${total_cost / len(used):.4f}")
        total = len(load_jsonl_lines(args.out / "urls.txt"))
        if total:
            print(f"Прогноз на все {total} товаров: ≈ ${total_cost / len(used) * total:.0f}")
    if failed:
        print("Неудачные товары можно отправить заново: submit (удачные он пропустит).")


def write_csv(path, rows):
    cols = [
        ("sku", lambda r, d: r.get("sku", "")), ("name", lambda r, d: r.get("name", "")),
        ("url", lambda r, d: r.get("url", "")), ("photos", lambda r, d: len(r.get("images", []))),
        ("package", lambda r, d: d.get("package", {}).get("type", "")),
        ("label_name", lambda r, d: d.get("label", {}).get("name", "")),
        ("abv", lambda r, d: d.get("label", {}).get("abv", "")),
        ("volume", lambda r, d: d.get("label", {}).get("volume", "")),
        ("ingredients", lambda r, d: d.get("label", {}).get("ingredients", "")),
        ("allergens", lambda r, d: d.get("label", {}).get("allergens", "")),
        ("energy_100ml", lambda r, d: d.get("label", {}).get("energy_100ml", "")),
        ("producer", lambda r, d: d.get("label", {}).get("producer", "")),
        ("address", lambda r, d: d.get("label", {}).get("address", "")),
        ("ean", lambda r, d: d.get("label", {}).get("ean", "")),
        ("style", lambda r, d: d.get("design", {}).get("style", "")),
        ("unreadable", lambda r, d: "; ".join(map(str, d.get("unreadable", [])))),
        ("status", lambda r, d: "ok" if r.get("data") is not None else (r.get("error") or r.get("stop_reason", ""))),
    ]
    with path.open("w", encoding="utf-8-sig", newline="") as f:  # BOM — чтобы Excel открыл кириллицу
        w = csv.writer(f, delimiter=";")
        w.writerow([c for c, _ in cols])
        for r in rows:
            d = r.get("data") if isinstance(r.get("data"), dict) else {}
            w.writerow([_safe(fn, r, d) for _, fn in cols])


def _safe(fn, r, d):
    try:
        v = fn(r, d)
    except (AttributeError, TypeError):
        return ""
    return v if isinstance(v, (str, int)) else json.dumps(v, ensure_ascii=False)


# ---------- CLI ----------

def main():
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument("--out", type=Path, default=HERE / "out", help="папка для файлов (по умолчанию out/ рядом)")
    sub = ap.add_subparsers(dest="cmd", required=True)
    sub.add_parser("urls", help="собрать ссылки на товары из карт сайта")
    p = sub.add_parser("prepare", help="найти у товаров артикул, название и фото")
    p.add_argument("--limit", type=int, default=0, help="сколько товаров взять (0 — все)")
    p.add_argument("--offset", type=int, default=0, help="сколько товаров пропустить с начала списка")
    p.add_argument("--urls-file", help="свой список ссылок на товары, по одной в строке")
    s = sub.add_parser("submit", help="отправить товары в Batch API")
    s.add_argument("--model", default="claude-opus-5-5", choices=sorted(BATCH_PRICES))
    s.add_argument("--effort", default="low", choices=["low", "medium", "high"],
                   help="сколько модели рассуждать: больше — дороже и тщательнее")
    s.add_argument("--dry-run", action="store_true", help="собрать запросы и показать размер, ничего не отправляя")
    s.add_argument("--force", action="store_true", help="отправить, даже если есть незабранные пакеты")
    sub.add_parser("status", help="показать, как идут пакеты")
    sub.add_parser("results", help="забрать ответы и посчитать стоимость")
    args = ap.parse_args()
    args.out.mkdir(parents=True, exist_ok=True)
    {"urls": cmd_urls, "prepare": cmd_prepare, "submit": cmd_submit,
     "status": cmd_status, "results": cmd_results}[args.cmd](args)


if __name__ == "__main__":
    main()
