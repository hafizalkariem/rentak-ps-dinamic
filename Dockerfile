# Gunakan base image PHP dengan FPM
FROM php:8.2-fpm-alpine

# Instal dependensi sistem yang dibutuhkan untuk ekstensi PHP dan aplikasi
RUN apk add --no-cache \
    nginx \
    mysql-client \
    curl \
    git \
    supervisor \
    fcgi \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Instal ekstensi PHP yang umum dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql opcache bcmath exif pcntl gd

# Set working directory di dalam kontainer
WORKDIR /app

# Instal Composer secara global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy kode aplikasi Laravel Anda dari folder 'backend' di host ke /app di kontainer
# Ini akan menyalin isi dari 'your-project-root/backend' ke '/app'
COPY backend /app

# Jalankan composer install
# Ini akan dijalankan SETELAH semua file Laravel (termasuk composer.json) disalin ke /app
RUN composer install --no-dev --optimize-autoloader

# Konfigurasi Nginx
# Path sekarang relatif terhadap root repositori: backend/docker/nginx/default.conf
COPY backend/docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Konfigurasi PHP-FPM
COPY backend/docker/php-fpm/www.conf /etc/php82/php-fpm.d/www.conf
COPY backend/docker/php-fpm/php.ini /etc/php82/conf.d/php.ini

# Konfigurasi Supervisor
COPY backend/docker/supervisord.conf /etc/supervisord.conf

# Atur izin direktori storage dan cache yang dibutuhkan Laravel
# Path sudah relatif terhadap WORKDIR /app
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Jalankan migrasi dan seeder di fase build (OPSIONAL, HANYA UNTUK DEV/TESTING)
# RUN php artisan migrate:fresh --seed --force || true

# Expose port yang akan digunakan Nginx (ini adalah PORT yang disediakan Railway)
EXPOSE ${PORT}

# Perintah untuk menjalankan Supervisor, yang akan mengelola Nginx dan PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]