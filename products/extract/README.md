# Сырые данные о товарах с фото (Claude Batch API)

`extract.py` собирает товары alkojuomat.com из карт сайта, находит у каждого фото галереи (версии 1024 px) и отправляет их в Claude Message Batches API с заданием из [`prompt.txt`](prompt.txt). По каждому товару приходит JSON с данными с упаковки: что на каждом фото, дизайн, все надписи, данные этикетки. Переводы и пояснения модели лежат отдельно, в блоке `notes`.

## Ключ API

- Ключ и баланс — в Claude Console (platform.claude.com). API оплачивается отдельно от подписки Claude.
- В облачной сессии Claude Code: меню облачного окружения в заголовке сессии → Edit → переменная окружения `ANTHROPIC_API_KEY` (или раздел API credentials, если он есть). Ключ подхватит новая сессия.
- На своём компьютере: `export ANTHROPIC_API_KEY=...` в терминале перед запуском.
- Не вставляйте ключ в чат, в код и в файлы репозитория.

## Пробный запуск на 25 товарах

Команды запускаются из корня репозитория, нужен Python 3.10+ и `pip install anthropic`.

```bash
python3 products/extract/extract.py urls                # ссылки на товары → out/urls.txt
python3 products/extract/extract.py prepare --limit 25  # артикул, название, фото → out/products.jsonl и оценка цены
python3 products/extract/extract.py submit --dry-run    # собрать запросы, ничего не отправляя
python3 products/extract/extract.py submit              # отправить пакет (нужен ключ)
python3 products/extract/extract.py status              # как идёт обработка
python3 products/extract/extract.py results             # забрать ответы и посчитать реальную цену
```

Пакет обычно обрабатывается до часа, максимум 24 часа.

## Все товары

```bash
python3 products/extract/extract.py prepare   # все товары из out/urls.txt
python3 products/extract/extract.py submit    # уже обработанные товары пропускаются
```

Скрипт сам делит работу на пакеты до 100 МБ. Товары с ошибками можно отправить заново тем же `submit`: удачные он пропустит.

## Параметры `submit`

- `--model`: `claude-opus-5-5` (по умолчанию), `claude-sonnet-5` (вдвое дешевле), `claude-opus-5`, `claude-haiku-4-5` (самая дешёвая, но мелкий текст читает хуже).
- `--effort`: `low` (по умолчанию), `medium`, `high` — сколько модели рассуждать. Больше — тщательнее и дороже. На пробе стоит сравнить `low` и `medium`.

Задание для модели можно править прямо в `prompt.txt`. Метки `%NAME%` и `%SKU%` скрипт подставляет сам.

## Что получается

- `out/results.jsonl` — строка на товар: артикул, название, ссылка, фото, `data` (JSON от модели), токены.
- `out/results.csv` — основные поля для Excel, разделитель `;`.
- У товаров с ошибками нет `data`, причина — в поле `error` или `stop_reason`.

Облачная сессия не хранит файлы после завершения, поэтому после `results` закоммитьте и запушьте папку `out/`.

## Стоимость

`prepare` показывает оценку, `results` — реальную цену по токенам из ответов API и прогноз на все товары. Оценка на все ~3 200 товаров при ~3 500 токенах ответа на товар: около $150–170 на Opus 5.5 и около $75 на Sonnet 5.
