FROM php:8.2-fpm

# 1. Install system dependencies
# Added libpq-dev in case you use Postgres, kept others.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    libonig-dev \
    ffmpeg \
    && docker-php-ext-install mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Set Working Directory
WORKDIR /var/www

# 4. Copy dependency files first (for better caching)
COPY composer.json composer.lock ./

# 5. Install dependencies without scripts (scripts might need the full app code)
RUN composer install --no-dev --no-scripts --no-autoloader

# 6. Copy the rest of the application
COPY . .

# 7. Finalize Composer (Generate optimized autoload)
RUN composer dump-autoload --optimize

# 8. Prepare Database and Permissions
RUN touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache

# Note: Running migrations during 'docker build' is generally discouraged 
# because the DB might not be ready. It's better in the CMD or Entrypoint.
# RUN php artisan migrate --force 

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]