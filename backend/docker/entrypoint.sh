#!/bin/bash

# Atur hak akses
chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database
chmod -R 777 /app/storage /app/bootstrap/cache /app/database

# Jalankan Supervisor untuk Caddy and PHP-FPM
exec /usr/bin/supervisord -c /etc/supervisord.conf