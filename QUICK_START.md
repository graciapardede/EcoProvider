# QUICK START - EcoProvider API

## Untuk Local Development

### 1. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 2. Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 3. Run Development Server
```bash
php artisan serve
# Akses di http://localhost:8000
```

### 4. Test API
```bash
# Status
curl http://localhost:8000/api/status

# News
curl http://localhost:8000/api/news

# Events
curl http://localhost:8000/api/events

# Tips
curl http://localhost:8000/api/tips
```

---

## Untuk Production Deployment

### 1. Update .env
```bash
# Copy template
cp .env.production.example .env

# Edit .env dengan credentials server
nano .env
```

### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Clear & Cache Configuration
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Set Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 644 public/.htaccess
```

### 5. Verify Deployment
```bash
# Test HTTPS redirect
curl -I http://bsdgs.fun/api/status

# Test API endpoints
curl https://bsdgs.fun/api/status
curl https://bsdgs.fun/api/news
curl https://bsdgs.fun/api/events
curl https://bsdgs.fun/api/tips

# Check logs
tail -20 storage/logs/api.log
```

---

## API Endpoints

### Status
- **GET** `/api/status` - API health check

### News
- **GET** `/api/news` - List all news
- **GET** `/api/news/{id}` - Get single news
- **GET** `/api/news-search?q=keyword` - Search news

### Events
- **GET** `/api/events` - List all events
- **GET** `/api/events/{id}` - Get single event

### Tips
- **GET** `/api/tips` - List all tips
- **GET** `/api/tips/{id}` - Get single tip

---

## CORS Whitelist

Domain yang diizinkan:
- `http://localhost:8000` (development)
- `https://bsdgs.fun` (production)
- `https://www.bsdgs.fun` (production)

Edit di `config/cors.php` jika ingin menambah domain.

---

## Monitoring Logs

### Real-time monitoring
```bash
tail -f storage/logs/api.log
```

### Daily rotating logs
```bash
ls -la storage/logs/
```

### Filter logs
```bash
# Lihat hanya error
grep "Status: 5" storage/logs/api.log

# Lihat hanya IP tertentu
grep "IP: 203.0.113.42" storage/logs/api.log

# Count total requests
wc -l storage/logs/api.log
```

---

## Troubleshooting

### API returns 403 CORS Error
```bash
php artisan config:clear
# Verify config/cors.php
# Restart web server
```

### HTTP not redirecting to HTTPS
```bash
# Check .htaccess
ls -la public/.htaccess

# Verify mod_rewrite enabled
apache2ctl -M | grep rewrite

# Restart Apache
sudo systemctl restart apache2
```

### No logs recorded
```bash
# Check permissions
chmod 775 storage/logs

# Check logging config
grep -A 8 "'api'" config/logging.php

# Test logging
php artisan tinker
Log::channel('api')->info('Test');
exit
```

### 500 Internal Server Error
```bash
# Check Laravel logs
tail -100 storage/logs/laravel.log

# Check PHP errors
tail -100 /var/log/apache2/error.log

# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

---

## Configuration Files

- `config/cors.php` - CORS settings
- `config/logging.php` - Logging configuration
- `routes/api.php` - API routes
- `public/.htaccess` - HTTPS redirect & rewrite rules
- `app/Providers/AppServiceProvider.php` - Application bootstrap
- `.env` - Environment variables

---

## Useful Commands

```bash
# List all routes
php artisan route:list

# Clear all caches
php artisan optimize:clear

# Cache all
php artisan optimize

# Migrate database
php artisan migrate

# Seed database
php artisan db:seed

# Tinker REPL
php artisan tinker

# Generate app key
php artisan key:generate
```

---

## Documentation

- **Full Guide:** `IMPLEMENTATION_GUIDE.md`
- **Debug Checklist:** `DEBUG_CHECKLIST.md`
- **API Documentation:** `API_DOCUMENTATION.md`

---

**Version:** 1.0.0
**Last Updated:** 12 December 2025
