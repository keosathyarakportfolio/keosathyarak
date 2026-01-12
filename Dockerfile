# ===== Final Laravel 8/9/10/12 Alpine Dockerfile =====
FROM php:8.2-fpm-alpine

# ----------------------------
# 1️⃣ Install system dependencies
# ----------------------------
RUN apk add --no-cache \
    git \
    unzip \
    curl \
    ffmpeg \
    oniguruma-dev \
    libxml2-dev \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    mysql-client \
    bash \
    shadow  # for user permissions

# ----------------------------
# 2️⃣ Install PHP extensions (only non-core)
# ----------------------------
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        bcmath \
        exif \
        gd \
        mbstring \
        pdo \
        pdo_mysql \
        zip \
        dom

# ----------------------------
# 3️⃣ Install Composer (official)
# ----------------------------
RUN  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# ----------------------------
# 4️⃣ Set working directory
# ----------------------------
WORKDIR /var/www/html

# ----------------------------
# 5️⃣ Copy composer files first (cache-friendly)
# ----------------------------


# ----------------------------
# 6️⃣ Install Laravel dependencies
# ----------------------------


# ----------------------------
# 7️⃣ Copy app source code
# ----------------------------
COPY . .
RUN rm composer.lock 
RUN composer install --no-dev --optimize-autoloader

# ----------------------------
# 8️⃣ Optional: create SQLite DB
# ----------------------------
RUN mkdir -p database && touch database/database.sqlite

# ----------------------------
# 9️⃣ Set permissions (Laravel storage/cache)
# ----------------------------
RUN chown -R www-data:www-data storage bootstrap/cache
RUN php artisan migrate 
# ----------------------------
# 10️⃣ Expose port and start server
# ----------------------------
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
