FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    supervisor \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    opcache \
    xml \
    gd \
    sockets\
    supervisor

# Configure GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a directory for supervisor config files
RUN mkdir -p /etc/supervisor/conf.d

# Add user and group for laravel
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -h /home/laravel -D laravel

# Set working directory
WORKDIR /var/www/laravel

# Copy the supervisord configuration
COPY ./supervisord.conf /etc/supervisor/supervisord.conf

# Create a directory for logs
RUN mkdir -p /var/log/supervisor && \
    chown -R laravel:laravel /var/log/supervisor

# Change ownership of our applications
RUN chown -R laravel:laravel /var/www/laravel

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]