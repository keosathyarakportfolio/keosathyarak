# --- Base image with PHP 8.2 and Composer ---
FROM php:8.2-fpm

# --- Install system dependencies + FFmpeg ---
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    python3 python3-pip ffmpeg \
    && docker-php-ext-install mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# --- Set working directory ---
WORKDIR /var/www/html

# --- Copy Laravel and Python files ---
COPY . .

# --- Install PHP dependencies ---
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
# --- Install Python dependencies ---
RUN pip install --upgrade pip
RUN pip install -r requirements.txt

# --- Expose ports ---
EXPOSE 8000 9000

# --- Start both Laravel and Python apps concurrently ---
CMD bash -c "php artisan serve --host=0.0.0.0 --port=8000 & uvicorn main:app --host 0.0.0.0 --port 9000"
