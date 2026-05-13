# SazeeAI — Deployment Guide

## Local Development (XAMPP)

### Prerequisites
- XAMPP with PHP 8.0+ and MySQL
- Composer

### First-time Setup
```bash
# 1. Install dependencies (already done)
composer install

# 2. Copy environment file
cp env .env
# Edit .env: set CI_ENVIRONMENT, database credentials, baseURL

# 3. Create database
# Open phpMyAdmin → create database named 'sazeeai' (utf8mb4_unicode_ci)

# 4. Run migrations
php spark migrate

# 5. Seed database
php spark db:seed MainSeeder
```

### Access
- App: http://localhost/sazeeai/public
- Admin: http://localhost/sazeeai/public/admin
- Admin credentials: `admin@sazeeai.com` / `Admin@1234`

---

## cPanel Shared Hosting Deployment

### Step 1 — Prepare Files Locally

```bash
# Install production dependencies only
composer install --no-dev --optimize-autoloader

# Set environment to production in .env
CI_ENVIRONMENT = production
```

### Step 2 — Upload Files

Option A — Subdomain (recommended):
1. Create subdomain `app.yourdomain.com` pointing to `/home/user/sazeeai/`
2. Upload **all project files** (including `app/`, `public/`, `vendor/`, `writable/`) to `/home/user/sazeeai/`
3. In cPanel → Subdomains, set document root to `/home/user/sazeeai/public`

Option B — Subdirectory:
1. Upload all files to `/home/user/public_html/sazeeai/`
2. Move contents of `public/` one level up into `public_html/sazeeai/`
3. Edit `public/index.php`: update paths to point to `../app` and `../vendor`

### Step 3 — Configure `.env`
```ini
CI_ENVIRONMENT = production
app.baseURL = 'https://app.yourdomain.com/'

database.default.hostname = localhost
database.default.database = cpanel_dbname
database.default.username = cpanel_dbuser
database.default.password = your_db_password
database.default.DBDriver = MySQLi
```

### Step 4 — Database Setup
1. cPanel → MySQL Databases → create database and user
2. Assign user to database (all privileges)
3. Via SSH or phpMyAdmin import, run:
   ```bash
   php spark migrate
   php spark db:seed MainSeeder
   ```
   Or import via phpMyAdmin if SSH is unavailable.

### Step 5 — File Permissions
```bash
chmod -R 755 writable/
chmod -R 755 public/
```

### Step 6 — `.htaccess` (public/.htaccess)
The `public/.htaccess` that ships with CI4 handles URL rewriting. Ensure `mod_rewrite` is enabled (it is on most cPanel hosts).

If accessing from a subdirectory (not subdomain), verify `RewriteBase` in `public/.htaccess`:
```apache
RewriteBase /sazeeai/
```

### Step 7 — Security Checklist
- [ ] `CI_ENVIRONMENT = production`
- [ ] Remove or restrict `writable/logs/` access
- [ ] Set strong `app.encryptionKey` in `.env`
- [ ] Enable HTTPS and set `app.forceGlobalSecureRequests = true`
- [ ] Change default admin password

---

## Directory Structure (Production)

```
/home/user/sazeeai/         ← project root (not web-accessible)
├── app/
├── vendor/
├── writable/
└── public/                 ← document root (web-accessible)
    ├── index.php
    └── .htaccess
```

---

## Useful spark Commands

```bash
php spark migrate           # Run pending migrations
php spark migrate:rollback  # Rollback last batch
php spark db:seed MainSeeder
php spark cache:clear
php spark routes            # List all routes
```
