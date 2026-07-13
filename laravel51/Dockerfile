FROM php:7.1-fpm-buster

ARG DEBIAN_FRONTEND=noninteractive

# ---------- system packages ----------
RUN echo "deb http://archive.debian.org/debian buster main contrib non-free" > /etc/apt/sources.list \
  && apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    vim \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install redis-5.3.7 && docker-php-ext-enable redis

# ---------- php extensions ----------
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    mbstring \
    tokenizer \
    xml \
    gd \
    zip \
    opcache

# ---------- composer ----------
COPY --from=composer:2.2.25 /usr/bin/composer /usr/bin/composer

# ---------- app ----------
WORKDIR /var/www/html
COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# ---------- permissions ----------
RUN mkdir -p storage bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]