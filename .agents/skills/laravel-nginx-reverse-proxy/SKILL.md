---
name: laravel-nginx-reverse-proxy
description: >-
  Deployment guide for Laravel + Livewire + TallStackUI websites running behind
  an Nginx reverse proxy (HTTPS termination to HTTP backend, subdomains vs subpaths,
  PHP-FPM configuration, file permissions, and TallStackUI subpath URL fixing).
  Use when configuring Nginx, troubleshooting 404/Mixed Content/permission errors,
  or deploying Laravel behind a reverse proxy or subpath.
---

# Laravel Behind Nginx Reverse Proxy

## 1. Nginx Server Block Rules
- Always point `root` to `<app>/public` (never `<app>` root, which exposes `.env`).
- Always use `try_files $uri $uri/ /index.php?$query_string;` (with leading `/index.php`, never `public/index.php`).
- Ensure `include snippets/fastcgi-php.conf;` is **uncommented** inside `location ~ \.php$` (commenting it drops `SCRIPT_FILENAME` and causes 404).
- **Never** add a `location ~* \.(js|css)$` static-only block without `try_files $uri /index.php?$query_string;`—TallStackUI (`/tallstackui/script/*.js`) and Livewire (`/livewire-*/livewire.min.js`) are dynamic PHP routes, not files on disk.

```nginx
server {
    listen 80;
    server_name example.com;

    root /var/www/app/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.5-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 2. Subdomain vs. Subpath (`/subpath/app`)
- **Preferred:** Use one subdomain per app so all package routes resolve at `/`.
- **When forced onto a subpath** (e.g. `https://domain.com/sms/app_name`):
  - Keep app root outside web root and symlink only `<app>/public` into `/var/www/sms/app_name`.
  - Set `APP_URL=https://domain.com/sms/app_name` and `SESSION_PATH=/sms/app_name` (isolates session cookies per app).
  - **Never** set `ASSET_URL=/` when serving from a subpath (it strips the subpath from `@vite` and `asset()`). Leave `ASSET_URL` unset or equal to `APP_URL`.

## 3. Storage & Cache Permissions
If `Filesystem::replace()` throws `tempnam(): file created in the system's temporary directory`:
```bash
mkdir -p /var/www/app/storage/framework/{cache/data,sessions,views}
mkdir -p /var/www/app/bootstrap/cache
sudo chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache
sudo chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache
```

## 4. Laravel Reverse Proxy & TallStackUI Subpath Fix
- In `bootstrap/app.php`: add `$middleware->trustProxies(at: '*');` so Laravel honors `X-Forwarded-Proto: https` and `X-Forwarded-Host` (eliminating `http://` Mixed Content errors without needing `URL::forceScheme('https')`).
- In `AppServiceProvider`:
  - **`register()`:** Bind `TallStackUi\Support\Blade\Directives` to rewrite TallStackUI's hardcoded root-relative `href="/tallstackui/` and `src="/tallstackui/` attributes with `rtrim(asset('tallstackui'), '/').'/'`.
  - **`boot()`:** If `APP_URL` has a non-root path prefix, call `URL::forceRootUrl($appUrl)` so `url()`, `route()`, and Livewire's `data-update-uri` keep the subpath even if the proxy strips prefixes.

## 5. Verification
```bash
sudo nginx -t && sudo systemctl reload nginx
php artisan optimize:clear
curl -I http://127.0.0.1/build/assets/app.css -H "Host: example.com"
sudo tail -n 20 /var/log/nginx/error.log
```
