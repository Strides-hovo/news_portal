FROM php:8.2-fpm

# системные пакеты и сборка расширений (включая sockets)
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      build-essential git curl zip unzip \
      libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
      libonig-dev libxml2-dev libxml2-dev linux-libc-dev \
      nodejs npm autoconf pkg-config \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" \
      pdo_mysql mbstring zip exif pcntl bcmath opcache xml gd sockets \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/laravel
COPY php.ini /usr/local/etc/php/conf.d/local.ini
RUN chown -R www-data:www-data /var/www/laravel

# запускаем только php-fpm
CMD ["php-fpm"]
