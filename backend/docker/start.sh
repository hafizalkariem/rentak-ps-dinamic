#!/bin/bash

# Set default port jika tidak ada
PORT=${PORT:-8080}

echo "Starting application on port $PORT"

# Update konfigurasi Nginx dengan port dinamis
sed -i "s/listen 80;/listen $PORT;/" /etc/nginx/http.d/default.conf

# Pastikan direktori log ada
mkdir -p /var/log/nginx
mkdir -p /var/log
touch /var/log/nginx/access.log
touch /var/log/nginx/error.log

# Set permissions
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache

# Jalankan Laravel optimizations
cd /app
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate key jika belum ada
php artisan key:generate --force || true

# Jalankan migration jika ada
php artisan migrate --force || true

# Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Test PHP-FPM
php-fpm -t

# Test Nginx config
nginx -t

echo "Starting services..."

# Start supervisor dengan konfigurasi yang sudah diperbarui
exec /usr/bin/supervisord -c /etc/supervisord.conf