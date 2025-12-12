# CONFIGURATION REFERENCE - EcoProvider API

## 📋 Konfigurasi yang Diubah

### 1. config/cors.php

**Original:**
```php
'allowed_origins' => ['http://127.0.0.1:8000', 'http://localhost:8000'],
```

**Updated:**
```php
'allowed_origins' => [
    'http://127.0.0.1:8000',
    'http://localhost:8000',
    'https://bsdgs.fun',
    'https://www.bsdgs.fun',
],
```

**Penjelasan:**
- `http://127.0.0.1:8000` - IP lokal untuk development
- `http://localhost:8000` - Hostname lokal untuk development
- `https://bsdgs.fun` - Production domain
- `https://www.bsdgs.fun` - Production domain dengan www

**Command untuk apply:**
```bash
php artisan config:clear
```

---

### 2. config/logging.php

**Added:**
```php
'api' => [
    'driver' => 'daily',
    'path' => storage_path('logs/api.log'),
    'level' => env('LOG_LEVEL', 'debug'),
    'days' => env('LOG_DAILY_DAYS', 14),
    'replace_placeholders' => true,
],
```

**Penjelasan:**
- `driver: daily` - Membuat file log baru setiap hari
- `path` - Lokasi file log: `storage/logs/api.log`
- `level: debug` - Catat semua messages (debug+)
- `days: 14` - Hapus log yang lebih dari 14 hari

---

### 3. app/Providers/AppServiceProvider.php

**Added:**
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

**Penjelasan:**
- Cek apakah environment production
- Jika production, force semua generated URLs menggunakan https
- Contoh: `asset('image.jpg')` akan menjadi `https://...` bukan `http://...`

---

### 4. bootstrap/app.php

**Added:**
```php
$middleware->api(append: [
    \App\Http\Middleware\ApiAccessLogger::class,
]);
```

**Penjelasan:**
- Register ApiAccessLogger middleware untuk semua route di `routes/api.php`
- Middleware akan otomatis berjalan sebelum setiap API request diproses

---

### 5. routes/api.php

**Added:**
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

**Penjelasan:**
- Tambah 3 controller baru untuk status, events, dan tips
- Masing-masing memiliki index (list) dan show (detail) method
- Route prefix otomatis `/api/` dari routes/api.php

---

### 6. public/.htaccess

**Added (di awal setelah RewriteEngine On):**
```apache
# Force HTTPS
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**Penjelasan:**
- `RewriteCond %{HTTPS} !=on` - Kondisi: HTTPS tidak aktif
- `RewriteRule ^(.*)$` - Match semua request
- `https://%{HTTP_HOST}%{REQUEST_URI}` - Redirect ke HTTPS
- `[L,R=301]` - Last rule, permanent redirect (301)

**Contoh hasil:**
- Request: `http://bsdgs.fun/api/news`
- Response: `301 Moved Permanently` → `https://bsdgs.fun/api/news`

---

## 🔧 Environment Variables (.env)

### Untuk Local Development
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
CORS_ALLOWED_ORIGINS=http://localhost:8000
```

### Untuk Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bsdgs.fun
CORS_ALLOWED_ORIGINS=http://localhost:8000,https://bsdgs.fun,https://www.bsdgs.fun
```

**Key differences:**
- `APP_ENV=production` - Disable debug output
- `APP_DEBUG=false` - Hide error details dari user
- `APP_URL` - Gunakan HTTPS di production
- `CORS_ALLOWED_ORIGINS` - Include development URL untuk testing

---

## 📝 Controllers Configuration

### StatusController (NEW)
**File:** `app/Http/Controllers/Api/StatusController.php`

**Endpoints:**
```
GET /api/status
```

**Response:**
```json
{
  "status": "ok",
  "timestamp": "2025-12-12T10:30:45.000000Z",
  "version": "1.0.0",
  "environment": "production",
  "api_url": "https://bsdgs.fun"
}
```

### EventsController (NEW)
**File:** `app/Http/Controllers/Api/EventsController.php`

**Endpoints:**
```
GET /api/events           - List all events
GET /api/events/{id}      - Get single event by ID
```

### TipsController (NEW)
**File:** `app/Http/Controllers/Api/TipsController.php`

**Endpoints:**
```
GET /api/tips             - List all tips
GET /api/tips/{id}        - Get single tip by ID
```

---

## 🔐 Middleware Configuration

### ApiAccessLogger (NEW)
**File:** `app/Http/Middleware/ApiAccessLogger.php`

**Features:**
1. Mencatat client IP address
2. Mencatat HTTP method (GET, POST, etc)
3. Mencatat full URL yang diakses
4. Mencatat HTTP status code response
5. Mengukur response time dalam milliseconds
6. Mencatat timestamp

**Log Format:**
```
[API ACCESS] IP: 203.0.113.42 | Method: GET | URL: https://bsdgs.fun/api/news | Status: 200 | Response Time: 45.32 ms | Time: 2025-12-12 10:30:45
```

**Configuration:**
- Registered di: `bootstrap/app.php`
- Log channel: `api` (defined in `config/logging.php`)
- Log file: `storage/logs/api.log`

---

## 🚦 CORS Configuration Details

**Current Settings:**

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'eco-news-search', 'eco-news-data'],
    
    'allowed_methods' => ['*'],  // All HTTP methods
    
    'allowed_origins' => [
        'http://127.0.0.1:8000',
        'http://localhost:8000',
        'https://bsdgs.fun',
        'https://www.bsdgs.fun',
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],  // All headers
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => false,
];
```

**CORS Headers yang di-generate:**
```
Access-Control-Allow-Origin: https://bsdgs.fun
Access-Control-Allow-Methods: GET, HEAD, PUT, PATCH, POST, DELETE
Access-Control-Allow-Headers: *
Access-Control-Max-Age: 0
```

---

## 🔗 HTTPS Configuration Details

### Method 1: Apache .htaccess
**Location:** `public/.htaccess`

```apache
# Force HTTPS
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**How it works:**
1. Browser requests `http://bsdgs.fun/api/news`
2. Apache receives request
3. Checks: Is HTTPS not enabled? (Yes)
4. Redirects to: `https://bsdgs.fun/api/news` (301 Moved)
5. Browser follows redirect to HTTPS

### Method 2: Laravel Force Scheme
**Location:** `app/Providers/AppServiceProvider.php`

```php
if (config('app.env') === 'production') {
    URL::forceScheme('https');
}
```

**How it works:**
- When using Laravel's `asset()` or `url()` functions
- Generated URLs akan selalu menggunakan HTTPS
- Example: `asset('image.jpg')` → `https://bsdgs.fun/storage/image.jpg`

**Both methods:**
- Ensure maximum security
- Cover all cases (direct requests + generated URLs)
- Recommended untuk production

---

## 📊 Logging Configuration

**Channel Name:** `api`

**Settings:**
```php
'api' => [
    'driver' => 'daily',              // Create new file each day
    'path' => storage_path('logs/api.log'),  // File location
    'level' => env('LOG_LEVEL', 'debug'),    // Debug level
    'days' => env('LOG_DAILY_DAYS', 14),     // Keep 14 days
    'replace_placeholders' => true,   // Replace placeholders
],
```

**Logging Usage:**
```php
// In ApiAccessLogger middleware
Log::channel('api')->info($logMessage);
Log::channel('api')->debug(json_encode($details));
```

**Log File Rotation:**
- Daily files: `api.log-2025-12-12`, `api.log-2025-12-11`, etc
- Old files: Automatically deleted after 14 days
- Location: `storage/logs/`

---

## 🔄 Configuration Update Process

### When you change config/cors.php:
```bash
php artisan config:clear
```
This clears the config cache so Laravel reads the fresh config.

### When you change routes/api.php:
```bash
php artisan route:clear
```
This clears the route cache.

### For Production, Cache Everything:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Clear All:
```bash
php artisan optimize:clear
```
Or individual:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📋 Configuration Checklist

Before going to production:

- [ ] `config/cors.php` updated with correct domains
- [ ] `config/logging.php` has 'api' channel
- [ ] `AppServiceProvider.php` forces HTTPS for production
- [ ] `bootstrap/app.php` registers ApiAccessLogger middleware
- [ ] `routes/api.php` has all new endpoints
- [ ] `public/.htaccess` has HTTPS redirect rule
- [ ] `.env` set to production values
- [ ] All caches cleared: `php artisan optimize:clear`
- [ ] Storage permissions correct: `chmod -R 775 storage`
- [ ] Logging test: `tail -20 storage/logs/api.log`

---

## 🆘 Configuration Verification

### Verify CORS
```bash
# Check config
cat config/cors.php | grep -A 5 "allowed_origins"

# Test CORS header
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status | grep -i cors
```

### Verify HTTPS
```bash
# Test redirect
curl -I http://bsdgs.fun/api/status | head -1
# Should return: HTTP/1.1 301 Moved Permanently

# Test direct HTTPS
curl -I https://bsdgs.fun/api/status | head -1
# Should return: HTTP/1.1 200 OK
```

### Verify Logging
```bash
# Check logging config
grep -A 8 "'api'" config/logging.php

# Check log file
ls -lh storage/logs/api.log

# Check recent logs
tail -10 storage/logs/api.log
```

### Verify Routes
```bash
# List all API routes
php artisan route:list | grep api

# Should see:
# GET|HEAD  api/status
# GET|HEAD  api/events
# GET|HEAD  api/events/{id}
# GET|HEAD  api/tips
# GET|HEAD  api/tips/{id}
```

---

**Version:** 1.0.0
**Last Updated:** 12 December 2025
**Status:** Ready for Production
