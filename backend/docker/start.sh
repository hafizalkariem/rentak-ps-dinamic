#!/bin/bash

# Set default port jika tidak ada
PORT=${PORT:-8080}

# Update konfigurasi Nginx dengan port dinamis
sed -i "s/listen 80;/listen $PORT;/" /etc/nginx/http.d/default.conf

# Jalankan Laravel optimizations
cd /app
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migration jika ada
php artisan migrate --force || true

# Start supervisor dengan konfigurasi yang sudah diperbarui
exec /usr/bin/supervisord -c /etc/supervisord.conf