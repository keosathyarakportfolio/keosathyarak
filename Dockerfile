# --- Base PHP image ---

FROM php:8.2-fpm

# --- Install system dependencies ---

RUN apt-get update && apt-get install -y \
    unzip git curl python3 python3-pip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# --- Install Composer ---
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# --- Install Node.js + npm ---
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs ffmpeg 

# --- Set working directory ---
WORKDIR /var/www

# --- Copy project files ---
COPY . .

# --- Install PHP dependencies (Laravel) ---
RUN composer install --no-dev --optimize-autoloader

# --- Install JS dependencies (Vite/Mix) ---
RUN npm install && npm run build

# --- Install Python dependencies ---
COPY requirements.txt /tmp/requirements.txt
RUN pip3 install --no-cache-dir -r /tmp/requirements.txt || true

# --- Expose ports for Laravel + Python ---
EXPOSE 10000 8000

# --- Run Laravel + Python together ---
CMD php artisan migrate --force && \
    (php artisan serve --host 0.0.0.0 --port 10000 &) && \
    (uvicorn backend.main:app --host 0.0.0.0 --port 8000 --reload)
