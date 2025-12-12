# PANDUAN IMPLEMENTASI - EcoProvider API Hosting

## 📋 Ringkasan Perubahan

Dokumentasi ini menjelaskan semua perubahan yang telah dilakukan untuk memperbaiki API EcoProvider agar dapat diakses dari GreenSaving di production.

---

## 1️⃣ PERBAIKAN CORS (config/cors.php)

### Apa yang Diubah?
File `config/cors.php` telah diupdate untuk memwhitelist domain GreenSaving dan localhost development.

### File yang Diubah
**File:** `config/cors.php`

**Perubahan:**
```php
'allowed_origins' => [
    'http://127.0.0.1:8000',
    'http://localhost:8000',
    'https://bsdgs.fun',
    'https://www.bsdgs.fun',
],
```

### Implementasi
```bash
# 1. Verify perubahan di file
cat config/cors.php

# 2. Clear configuration cache
php artisan config:clear

# 3. (Optional) Cache configuration untuk production
php artisan config:cache
```

### Verifikasi CORS
```bash
# Test CORS headers
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status

# Expected response headers:
# Access-Control-Allow-Origin: https://bsdgs.fun
# Access-Control-Allow-Methods: GET, HEAD, PUT, PATCH, POST, DELETE
# Access-Control-Allow-Headers: Content-Type, Accept, Authorization
```

---

## 2️⃣ IMPLEMENTASI HTTPS FORCE

### Apa yang Diubah?
Ada dua langkah untuk memaksa HTTPS:

#### A. Update .htaccess (public/.htaccess)
File `.htaccess` sudah diupdate dengan rule untuk redirect HTTP → HTTPS.

**Perubahan ditambahkan di awal RewriteEngine:**
```apache
# Force HTTPS
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

#### B. Update AppServiceProvider (app/Providers/AppServiceProvider.php)
Ditambahkan `URL::forceScheme('https')` untuk production.

**Perubahan:**
```php
use Illuminate\Support\Facades\URL;

public function boot(): void
{
    Paginator::useTailwind();

    // Force HTTPS in production
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
}
```

### Implementasi
```bash
# 1. Verify .htaccess exists
ls -la public/.htaccess

# 2. Verify mod_rewrite enabled di Apache
apache2ctl -M | grep rewrite

# 3. Restart Apache
sudo systemctl restart apache2  # Linux
# atau
sudo apachectl restart  # macOS
```

### Verifikasi HTTPS
```bash
# Test HTTP redirect to HTTPS
curl -I http://bsdgs.fun/api/status
# Expected: 301 Moved Permanently ke https://

# Test direct HTTPS
curl -I https://bsdgs.fun/api/status
# Expected: 200 OK
```

---

## 3️⃣ PERBAIKAN ROUTING API & CONTROLLER BARU

### Apa yang Diubah?
Ditambahkan 3 controller baru dan route baru di routes/api.php

### File yang Dibuat/Diubah

#### A. Status Controller
**File:** `app/Http/Controllers/Api/StatusController.php`

```php
// Endpoint: GET /api/status
// Returns: {"status":"ok","timestamp":"...","version":"1.0.0",...}
```

#### B. Events Controller
**File:** `app/Http/Controllers/Api/EventsController.php`

```php
// Endpoints:
// GET /api/events        - List semua events
// GET /api/events/{id}   - Detail single event
```

#### C. Tips Controller
**File:** `app/Http/Controllers/Api/TipsController.php`

```php
// Endpoints:
// GET /api/tips        - List semua tips
// GET /api/tips/{id}   - Detail single tip
```

#### D. Routes API
**File:** `routes/api.php`

Ditambahkan:
```php
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\TipsController;

// Status API Route
Route::get('/status', [StatusController::class, 'status']);

// Events API Routes
Route::get('/events', [EventsController::class, 'index']);
Route::get('/events/{id}', [EventsController::class, 'show']);

// Tips API Routes
Route::get('/tips', [TipsController::class, 'index']);
Route::get('/tips/{id}', [TipsController::class, 'show']);
```

### Implementasi
```bash
# 1. Verify routes registered
php artisan route:list | grep api

# 2. Clear route cache
php artisan route:clear

# 3. Cache routes untuk production
php artisan route:cache
```

### Verifikasi API Endpoints
```bash
# Test /api/status
curl https://bsdgs.fun/api/status

# Test /api/news
curl https://bsdgs.fun/api/news

# Test /api/events
curl https://bsdgs.fun/api/events

# Test /api/tips
curl https://bsdgs.fun/api/tips

# Test detail endpoint
curl https://bsdgs.fun/api/news/1
curl https://bsdgs.fun/api/events/1
curl https://bsdgs.fun/api/tips/1
```

---

## 4️⃣ MIDDLEWARE LOGGING (ApiAccessLogger)

### Apa yang Diubah?
Dibuat middleware baru untuk mencatat setiap request ke API dengan detail:
- Client IP
- HTTP Method
- Full URL
- HTTP Status Code
- Response time (ms)
- Timestamp

### File yang Dibuat/Diubah

#### A. ApiAccessLogger Middleware
**File:** `app/Http/Middleware/ApiAccessLogger.php`

Middleware ini:
- Mencatat setiap request sebelum diproses
- Mengukur response time
- Menyimpan log ke file `storage/logs/api.log`

#### B. Logging Configuration
**File:** `config/logging.php`

Ditambahkan channel 'api':
```php
'api' => [
    'driver' => 'daily',
    'path' => storage_path('logs/api.log'),
    'level' => env('LOG_LEVEL', 'debug'),
    'days' => env('LOG_DAILY_DAYS', 14),
    'replace_placeholders' => true,
],
```

#### C. Bootstrap Configuration
**File:** `bootstrap/app.php`

Middleware sudah terdaftar:
```php
$middleware->api(append: [
    \App\Http\Middleware\ApiAccessLogger::class,
]);
```

### Implementasi
```bash
# 1. Verify middleware registered
grep -n "ApiAccessLogger" bootstrap/app.php

# 2. Verify logging config
grep -A 8 "'api'" config/logging.php

# 3. Check if logs directory exists
ls -la storage/logs/

# 4. If not, create and set permissions
mkdir -p storage/logs
chmod 775 storage/logs

# 5. Test logging by making API request
curl https://bsdgs.fun/api/status

# 6. Check logs
tail -20 storage/logs/api.log
```

### Log Format
Setiap request akan dicatat dalam format:
```
[API ACCESS] IP: 203.0.113.42 | Method: GET | URL: https://bsdgs.fun/api/news | Status: 200 | Response Time: 45.32 ms | Time: 2025-12-12 10:30:45
```

### Monitoring Logs
```bash
# Real-time tail of API logs
tail -f storage/logs/api.log

# Count requests
wc -l storage/logs/api.log

# Filter by status code
grep "Status: 200" storage/logs/api.log

# Filter by IP
grep "IP: 203.0.113.42" storage/logs/api.log

# Get latest 100 requests
tail -100 storage/logs/api.log
```

---

## 5️⃣ DEBUG CHECKLIST & DOKUMENTASI

### File yang Dibuat
**File:** `DEBUG_CHECKLIST.md`

Dokumentasi lengkap berisi:
- ✅ Verification untuk SSL/HTTPS
- ✅ Verification untuk CORS
- ✅ Verification untuk semua API endpoints
- ✅ Troubleshooting guide
- ✅ Final verification commands
- ✅ Deployment checklist

---

## 🚀 DEPLOYMENT STEPS

### Step 1: Backup Current State
```bash
# SSH ke server production
ssh user@bsdgs.fun

# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup current code
cp -r ~/public_html ~/public_html_backup_$(date +%Y%m%d_%H%M%S)
```

### Step 2: Pull Latest Code
```bash
cd ~/public_html  # atau lokasi project Anda
git pull origin main

# Atau jika tanpa git, upload files via FTP/SFTP
```

### Step 3: Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### Step 4: Update Environment
```bash
# Edit .env
nano .env

# Pastikan setting ini:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bsdgs.fun
CORS_ALLOWED_ORIGINS=http://localhost:8000,https://bsdgs.fun,https://www.bsdgs.fun
```

### Step 5: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Step 6: Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 7: Set Permissions
```bash
# Untuk Linux/Unix
chmod -R 755 .
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 644 public/.htaccess

# Set owner (jika perlu)
chown -R www-data:www-data ~/public_html
```

### Step 8: Verify Deployment
```bash
# Run verification commands dari DEBUG_CHECKLIST.md
curl https://bsdgs.fun/api/status
curl https://bsdgs.fun/api/news
curl https://bsdgs.fun/api/events
curl https://bsdgs.fun/api/tips

# Check logs
tail -20 storage/logs/api.log
```

---

## ✅ POST-DEPLOYMENT CHECKLIST

Setelah deployment, verifikasi:

- [ ] HTTPS working (`curl -I https://bsdgs.fun/api/status`)
- [ ] CORS working (test dari browser GreenSaving)
- [ ] All endpoints accessible
- [ ] Logs being recorded in `storage/logs/api.log`
- [ ] File permissions correct
- [ ] Database migrated (if needed)
- [ ] Cache cleared
- [ ] .env configured for production
- [ ] Email notifications working (if applicable)
- [ ] Background jobs running (if applicable)

---

## 🔧 TROUBLESHOOTING

### Problem: CORS Error
```bash
# Check CORS config
cat config/cors.php

# Clear cache and test
php artisan config:clear
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status
```

### Problem: HTTPS Not Forcing
```bash
# Check .htaccess
head -20 public/.htaccess

# Verify mod_rewrite
apache2ctl -M | grep rewrite

# Restart Apache
sudo systemctl restart apache2
```

### Problem: No Logs
```bash
# Check directory
ls -la storage/logs/

# Fix permissions
chmod 775 storage/logs

# Test logging manually
php artisan tinker
Log::channel('api')->info('Test entry');
```

### Problem: 500 Errors
```bash
# Check Laravel log
tail -50 storage/logs/laravel.log

# Check PHP errors
tail -50 /var/log/apache2/error.log

# Test database
php artisan tinker
DB::connection()->getPdo();
```

---

## 📚 REFERENCE DOCUMENTATION

### Config Files Modified
- `config/cors.php` - CORS whitelist
- `config/logging.php` - Logging configuration
- `app/Providers/AppServiceProvider.php` - HTTPS force

### Controllers Created
- `app/Http/Controllers/Api/StatusController.php`
- `app/Http/Controllers/Api/EventsController.php`
- `app/Http/Controllers/Api/TipsController.php`

### Middleware Created
- `app/Http/Middleware/ApiAccessLogger.php`

### Routes Updated
- `routes/api.php` - Added new endpoints

### Files Configured
- `public/.htaccess` - HTTPS redirect
- `bootstrap/app.php` - Middleware registration

---

## 📞 SUPPORT

Jika ada pertanyaan atau masalah:
1. Refer ke `DEBUG_CHECKLIST.md`
2. Check logs di `storage/logs/api.log`
3. Test endpoints manually dengan curl
4. Verify configuration di .env

---

**Dokumentasi dibuat:** 12 December 2025
**Version:** 1.0.0
**Status:** Ready for Production Deployment
