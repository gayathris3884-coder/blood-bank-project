Importing the SQL dump (two preferred options)

1) Recommended: use psql (PowerShell)

Open PowerShell and run:

```powershell
psql "host=HOST port=PORT dbname=DBNAME user=USER password=PASSWORD sslmode=require" -f .\sql\blood_bank_database.sql
```

Replace HOST/PORT/DBNAME/USER/PASSWORD with your credentials. Example:

```powershell
psql "host=dpg-d45of3ruibrs73fan6h0-a port=5432 dbname=bdms user=bdmsuser password=PCbF8Ybzrq04GIWz7c9UXyOf6KekAaKe sslmode=require" -f .\sql\blood_bank_database.sql
```

Notes:
- psql is the most reliable method and will correctly interpret COPY, large function bodies and other psql-specific constructs.
- If psql is not available on your machine, install the PostgreSQL client tools or use your cloud provider's import UI.

2) Alternative: run the PHP migration script included in this repo

A convenience script is available at `scripts/import_sql.php`. It attempts to run the SQL via PHP's pg_query. It's suitable for simple dumps but may fail for very complex SQL dumps.

Usage (env vars):
- Set the environment variables for the DB connection then run:

```powershell
$env:DB_HOST = 'HOST'
$env:DB_PORT = '5432'
$env:DB_NAME = 'bdms'
$env:DB_USER = 'bdmsuser'
$env:DB_PASSWORD = 'YourPassword'
php .\scripts\import_sql.php
```

Usage (CLI args):

```powershell
php .\scripts\import_sql.php --host=HOST --port=5432 --dbname=bdms --user=bdmsuser --password=YourPassword --file=.\sql\blood_bank_database.sql
```

When to prefer the PHP script:
- You cannot run psql for some reason and the SQL is simple (no COPY, no psql-only commands).
- You want a quick local import without installing the PostgreSQL client.

If the PHP script fails on a chunk, it will report which chunk failed and recommend using psql.

Security reminder:
- Do not commit production credentials. Use environment variables or your provider's secrets.
- Do not run this script on a public server or with credentials hard-coded into the file.
