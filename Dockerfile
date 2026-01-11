FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libxml2-dev zip \
    ffmpeg libonig-dev \
    && docker-php-ext-install mbstring exif pcntl bcmath gd pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Create SQLite database file (if using SQLite)
RUN mkdir -p database && touch database/database.sqlite

# Run migrations
RUN php artisan migrate --force

EXPOSE 8000 9000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
