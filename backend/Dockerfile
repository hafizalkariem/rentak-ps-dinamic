# Gunakan base image PHP dengan FPM
FROM php:8.2-fpm-alpine

# Instal dependensi sistem yang dibutuhkan
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

# Copy kode aplikasi Laravel Anda dari host (lokasi Dockerfile berada) ke /app di kontainer
# Karena Dockerfile ada di 'backend/', ini akan menyalin seluruh isi 'backend/'
COPY . /app

# Konfigurasi Nginx
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
# Jika ada nginx.conf global, bisa juga disalin:
# COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Konfigurasi PHP-FPM
COPY docker/php-fpm/www.conf /etc/php82/php-fpm.d/www.conf 
COPY docker/php-fpm/php.ini /etc/php82/conf.d/php.ini

# Konfigurasi Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Atur izin direktori storage dan cache yang dibutuhkan Laravel
# Path sudah relatif terhadap WORKDIR /app
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Jalankan composer install
# Ini harus dijalankan setelah semua file Laravel disalin
RUN composer install --no-dev --optimize-autoloader

# Jalankan migrasi dan seeder di fase build (OPSIONAL, HANYA UNTUK DEV/TESTING)
# Jika Anda tetap menggunakan 'composer install && php artisan migrate:fresh --seed' di Build Command Railway, baris ini bisa dihapus
# RUN php artisan migrate:fresh --seed --force || true

# Expose port yang akan digunakan Nginx (ini adalah PORT yang disediakan Railway)
EXPOSE ${PORT}

# Perintah untuk menjalankan Supervisor, yang akan mengelola Nginx dan PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]