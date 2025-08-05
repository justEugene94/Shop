FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    libmcrypt-dev \
    icu-dev \
    libpq-dev \
    zlib-dev \
    curl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install gd \
        mysqli \
        pdo_mysql \
        intl \
        shmop \
        exif \
        zip

WORKDIR /var/www

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
RUN chmod 777 /var/log
COPY conf.ini $PHP_INI_DIR/conf.d/
