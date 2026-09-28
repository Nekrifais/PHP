# Сырые данные о товарах с фото (Claude Batch API)

`extract.py` собирает товары alkojuomat.com из карт сайта, находит у каждого фото галереи (версии 1024 px) и отправляет их в Claude Message Batches API с заданием из [`prompt.txt`](prompt.txt). По каждому товару приходит JSON с данными с упаковки: что на каждом фото, дизайн, все надписи, данные этикетки. Переводы и пояснения модели лежат отдельно, в блоке `notes`.

## Ключ API

Скрипт читает ключ из переменной окружения `EXTRACT_API_KEY`. Имя отдельное, чтобы ключ не подхватил сам Claude Code: `ANTHROPIC_API_KEY` он читает для своей работы.

1. **Ключ.** В Claude Console организации: [Settings → API keys](https://platform.claude.com/settings/keys) → **Create key**. В поле workspace выберите одно рабочее пространство. Ключ начинается с `sk-ant-` и показывается один раз. Лучше завести для задачи отдельное пространство с лимитом расходов: [Settings → Workspaces](https://platform.claude.com/settings/workspaces) → **Create workspace**, затем вкладка **Spend limits** (создавать может только администратор организации).
2. **Облачная сессия Claude Code.** На [claude.ai/code](https://claude.ai/code) нажмите кнопку с облаком и названием окружения над полем ввода, наведите на окружение и нажмите шестерёнку. В поле **Environment variables** добавьте строку `EXTRACT_API_KEY=sk-ant-…` и сохраните. Раздел **API credentials** не подойдёт: ключи для `api.anthropic.com` он не подставляет. Переменную увидит только новая сессия.
3. **Свой компьютер.** `export EXTRACT_API_KEY=sk-ant-…` в терминале перед запуском.

Не вставляйте ключ в чат, в код и в файлы репозитория.

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
