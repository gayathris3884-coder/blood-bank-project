# Railway Deployment Guide for BDMS

This file contains copy-paste steps to deploy your BDMS PHP app to Railway and to import the MySQL dump.

1) Push repository to GitHub

```powershell
cd C:\xampp\htdocs\BDMS
# initialize and push (run only if repo not already pushed)
git init
git add .
git commit -m "Initial BDMS import"
git branch -M main
# replace <your-username> and <repo> with your GitHub details
git remote add origin https://github.com/<your-username>/blood-bank-project.git
git push -u origin main
```

2) Create a Railway project
- Web UI: https://railway.app → New Project → Start from GitHub → select this repository.
- Or create an Empty Project and add services/plugins later.

3) Add MySQL plugin (Railway plugin)
- In the Railway project click + Add → MySQL. Railway will provision a database and show connection details.

4) Import the SQL dump
- If Railway provides a web import tool, use it.
- Otherwise use your local mysql client (example PowerShell):

```powershell
$host = 'RAILWAY_HOST'
$port = 'RAILWAY_PORT'
$user = 'RAILWAY_USER'
$pass = 'RAILWAY_PASS'
$db   = 'RAILWAY_DB'
$sqlfile = 'C:\xampp\htdocs\BDMS\sql\blood_bank_database.sql'

# Prompt for password (safer)
& 'C:\xampp\mysql\bin\mysql.exe' -h $host -P $port -u $user -p $db < $sqlfile
```

- If Railway blocks external connections, run `railway connect` and import through the local tunnel.

5) Set environment variables for your Railway service
- In the Railway service settings → Variables, add:
  - DB_HOST = RAILWAY_HOST
  - DB_PORT = RAILWAY_PORT
  - DB_USER = RAILWAY_USER
  - DB_PASS = RAILWAY_PASS
  - DB_NAME = RAILWAY_DB
  - (Optional) DATABASE_URL = mysql://user:pass@host:port/db

6) Deploy the service
- Railway will build your repo. If you have a Dockerfile, it will use it. If not, use the platform build.
- After deployment, open the service public URL and test `home.php`.

7) Debugging
- Check Railway logs for "Connection failed" messages from `conn.php`.
- Verify the tables exist by connecting to the DB and running `SHOW TABLES;`.


If you want, I can:
- Create or modify files in the repo (Dockerfile already present). I added `.dockerignore` and this guide.
- Generate exact `railway` CLI commands for your setup.

