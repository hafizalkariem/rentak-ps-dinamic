#!/bin/bash

# Atur hak akses
chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database
chmod -R 777 /app/storage /app/bootstrap/cache /app/database

# Jalankan migrasi database dari awal dan seed data
# php artisan migrate

# Jalankan Supervisor untuk Nginx dan PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisord.conf