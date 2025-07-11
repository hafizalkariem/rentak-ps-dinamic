# Gunakan base image PHP dengan FPM
FROM php:8.3-fpm-alpine

# Instal dependensi sistem
RUN apk add --no-cache \
    nginx \
    mysql-client \
    supervisor \
    bash

# Instal ekstensi PHP
RUN docker-php-ext-install pdo_mysql opcache bcmath exif pcntl

# Set working directory
WORKDIR /app

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Salin file composer terlebih dahulu untuk caching
COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction

# Salin sisa kode aplikasi
COPY backend/ /app

# Buat file .env dari .env.example
RUN cp .env.example .env

# Jalankan sisa perintah composer dan generate key
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    php artisan key:generate --force

# Cache konfigurasi dan rute untuk produksi
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Konfigurasi Nginx, PHP-FPM, dan Supervisor
COPY backend/docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY backend/docker/php-fpm/www.conf /etc/php83/php-fpm.d/www.conf
COPY backend/docker/php-fpm/php.ini /etc/php83/conf.d/php.ini
COPY backend/docker/supervisord.conf /etc/supervisord.conf

# Atur hak akses
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Buat skrip entrypoint
COPY backend/docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port 8080
EXPOSE 8080

# Jalankan entrypoint
CMD ["/entrypoint.sh"]
