FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libxml2-dev zip \
    ffmpeg libonig-dev \ 
    && docker-php-ext-install mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN git clone --depth 1 https://github.com/keosathyarakportfolio/downloader.git d

WORKDIR /var/www/html/d

RUN composer install --no-dev --optimize-autoloader

RUN touch /var/www/html/d/database/database.sqlite && php artisan migrate --force

EXPOSE 8000 9000

CMD ["bash", "-c", "php artisan serve --host=0.0.0.0 --port=8000"]