# DEBUG CHECKLIST - EcoProvider API Hosting

## Checklist Verifikasi Production

Gunakan checklist ini untuk memastikan API berfungsi dengan baik di production.

### 1. ✅ SSL/HTTPS Verification
- [ ] Akses ke `https://bsdgs.fun/api/status` berhasil (tidak ada SSL error)
- [ ] Akses ke `http://bsdgs.fun` otomatis redirect ke `https://`
- [ ] Certificate valid dan tidak expired
- [ ] Cek SSL: `https://www.ssllabs.com/ssltest/` atau `https://crt.sh/`

**Command untuk test:**
```bash
# Test HTTPS
curl -I https://bsdgs.fun/api/status

# Test HTTP redirect
curl -I http://bsdgs.fun/api/status

# Verify SSL certificate
openssl s_client -connect bsdgs.fun:443 -showcerts
```

---

### 2. ✅ CORS Verification
- [ ] Frontend GreenSaving bisa akses API tanpa CORS error
- [ ] Request dari `https://bsdgs.fun` diterima
- [ ] Request dari `https://www.bsdgs.fun` diterima
- [ ] Request dari `http://localhost:8000` masih berfungsi untuk development

**Command untuk test CORS:**
```bash
# Test CORS headers
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status

# Dengan OPTIONS request
curl -X OPTIONS -H "Origin: https://bsdgs.fun" \
  -H "Access-Control-Request-Method: GET" \
  https://bsdgs.fun/api/status -v
```

---

### 3. ✅ API Endpoints Verification
- [ ] `/api/status` - Returns `{"status": "ok"}`
- [ ] `/api/news` - Returns list of news
- [ ] `/api/news/{id}` - Returns single news detail
- [ ] `/api/events` - Returns list of events
- [ ] `/api/events/{id}` - Returns event detail
- [ ] `/api/tips` - Returns list of tips
- [ ] `/api/tips/{id}` - Returns tip detail

**Command untuk test API:**
```bash
# Test status endpoint
curl https://bsdgs.fun/api/status

# Test news endpoint
curl https://bsdgs.fun/api/news

# Test events endpoint
curl https://bsdgs.fun/api/events

# Test tips endpoint
curl https://bsdgs.fun/api/tips
```

---

### 4. ✅ Browser Accessibility
Buka di browser dan pastikan tidak ada error:

- [ ] `https://bsdgs.fun/api/status`
- [ ] `https://bsdgs.fun/api/news`
- [ ] `https://bsdgs.fun/api/events`
- [ ] `https://bsdgs.fun/api/tips`

**Expected Response:**
```json
{
  "status": "ok",
  "timestamp": "2025-12-12T10:30:00.000000Z",
  "version": "1.0.0",
  "environment": "production",
  "api_url": "https://bsdgs.fun"
}
```

---

### 5. ✅ Firewall & Network
- [ ] Port 80 (HTTP) terbuka untuk redirect
- [ ] Port 443 (HTTPS) terbuka
- [ ] DNS mengarah ke server yang benar
- [ ] IP server tidak di-block oleh firewall
- [ ] Tidak ada rate limiting yang tidak perlu

**Command untuk test:**
```bash
# Test connectivity
ping bsdgs.fun
nslookup bsdgs.fun

# Test port
curl -v https://bsdgs.fun/api/status
```

---

### 6. ✅ Subdomain Pointing
- [ ] Domain `bsdgs.fun` mengarah ke `public/` folder
- [ ] Subdomain `www.bsdgs.fun` mengarah ke `public/` folder
- [ ] `.htaccess` ada di folder `public/`
- [ ] `index.php` ada di `public/`

**Verifikasi struktur:**
```bash
# SSH ke server dan check
ls -la /path/to/public/
ls -la /path/to/public/.htaccess
cat /path/to/public/.htaccess  # Pastikan HTTPS redirect ada
```

---

### 7. ✅ File Permissions
- [ ] `storage/logs/` dapat ditulis oleh web server
- [ ] `bootstrap/cache/` dapat ditulis oleh web server
- [ ] `storage/app/` dapat ditulis oleh web server

**Command untuk check & fix:**
```bash
# Check permissions
ls -la storage/logs/
ls -la bootstrap/cache/

# Fix permissions (jika diperlukan)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

### 8. ✅ Configuration Caching
- [ ] Jalankan cache clear setelah setiap perubahan config:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimal: Cache config untuk production
php artisan config:cache
php artisan route:cache
```

---

### 9. ✅ Logging Verification
- [ ] File log ada di `storage/logs/api.log`
- [ ] Log tercatat setiap request ke API
- [ ] Log format: `IP | Method | URL | Status | Response Time | Timestamp`

**Command untuk check logs:**
```bash
# Check API logs
tail -f storage/logs/api.log

# Check Laravel logs
tail -f storage/logs/laravel.log

# Real-time monitoring
watch -n 1 'tail -20 storage/logs/api.log'
```

---

### 10. ✅ Environment Configuration
- [ ] `.env` sudah di-set untuk production:
  ```env
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://bsdgs.fun
  CORS_ALLOWED_ORIGINS=http://localhost:8000,https://bsdgs.fun,https://www.bsdgs.fun
  ```

- [ ] Database connection valid
- [ ] Cache driver dikonfigurasi (redis/file)

---

## Quick Troubleshooting Guide

### CORS Error
**Problem:** `Access to XMLHttpRequest at 'https://bsdgs.fun/api/...' from origin 'https://bsdgs.fun' has been blocked by CORS policy`

**Solution:**
```bash
# 1. Verify CORS config
cat config/cors.php

# 2. Clear cache
php artisan config:clear

# 3. Check response headers
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status

# 4. Restart web server
sudo systemctl restart apache2  # atau nginx
```

---

### HTTPS Redirect Not Working
**Problem:** HTTP tidak redirect ke HTTPS

**Solution:**
```bash
# 1. Check .htaccess exists
ls -la public/.htaccess

# 2. Verify mod_rewrite is enabled
apache2ctl -M | grep rewrite

# 3. Check .htaccess content
head -15 public/.htaccess

# 4. Restart Apache
sudo systemctl restart apache2
```

---

### API Logs Not Appearing
**Problem:** Logs tidak terekam di `storage/logs/api.log`

**Solution:**
```bash
# 1. Check directory exists
ls -la storage/logs/

# 2. Check permissions
stat storage/logs/
chmod -R 775 storage/logs/

# 3. Check logging config
grep -A 10 "'api'" config/logging.php

# 4. Create file manually if needed
touch storage/logs/api.log
chmod 664 storage/logs/api.log

# 5. Test logging
php artisan tinker
Log::channel('api')->info('Test log entry');
exit
```

---

### Database Connection Issues
**Problem:** API returns database error

**Solution:**
```bash
# 1. Test database connection
php artisan tinker
DB::connection()->getPdo();
exit

# 2. Run migrations if needed
php artisan migrate

# 3. Check .env database credentials
grep DB_ .env
```

---

## Final Verification Commands

Jalankan commands ini untuk final verification:

```bash
#!/bin/bash
echo "=== EcoProvider API Final Verification ==="

echo "\n1. Checking HTTPS..."
curl -I https://bsdgs.fun/api/status

echo "\n2. Checking Status Endpoint..."
curl https://bsdgs.fun/api/status | jq .

echo "\n3. Checking News Endpoint..."
curl https://bsdgs.fun/api/news | jq '.data | length'

echo "\n4. Checking CORS Headers..."
curl -I -H "Origin: https://bsdgs.fun" https://bsdgs.fun/api/status | grep -i cors

echo "\n5. Checking API Log..."
tail -5 storage/logs/api.log

echo "\n6. Checking File Permissions..."
ls -ld storage
ls -ld bootstrap/cache

echo "\n=== Verification Complete ==="
```

---

## Deployment Checklist

Sebelum go-live, pastikan:

1. **Code**
   - [ ] Semua file sudah di-push ke repository
   - [ ] `.env` sudah dikonfigurasi untuk production
   - [ ] No debug code atau console.log di API

2. **Configuration**
   - [ ] `APP_ENV=production`
   - [ ] `APP_DEBUG=false`
   - [ ] CORS domains sudah di-whitelist
   - [ ] Database connected

3. **Security**
   - [ ] HTTPS aktif
   - [ ] `.htaccess` sudah di-update
   - [ ] SSL certificate valid
   - [ ] Firewall rules sudah dikonfigurasi

4. **Monitoring**
   - [ ] Logs ada dan bisa ditulis
   - [ ] Monitoring tools aktif (jika ada)
   - [ ] Alert system configured (jika ada)

5. **Testing**
   - [ ] Semua endpoint tested
   - [ ] CORS tested dari frontend
   - [ ] Load testing dilakukan
   - [ ] Error handling tested

---

## Support & Resources

- **Laravel Docs:** https://laravel.com/docs
- **CORS Guide:** https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
- **SSL Testing:** https://www.ssllabs.com/ssltest/
- **DNS Checker:** https://mxtoolbox.com/

---

**Last Updated:** 12 December 2025
**Version:** 1.0.0
