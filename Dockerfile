FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libxml2-dev zip \
    python3 python3-pip ffmpeg libonig-dev python3.13-venv \
    && docker-php-ext-install mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN git clone --depth 1 https://github.com/keosathyarakportfolio/downloader.git d

WORKDIR /var/www/html/d

RUN composer install --no-dev --optimize-autoloader

RUN python3 -m venv .venv

RUN python3 -m venv .venv \
    && .venv/bin/pip install --upgrade pip \
    && .venv/bin/pip install -r requirements.txt \
    && .venv/bin/pip show uvicorn

RUN php artisan migrate

EXPOSE 8000 9000

CMD ["bash", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & source .venv/bin/activate && uvicorn backend.main:app --host 0.0.0.0 --port 9000"]