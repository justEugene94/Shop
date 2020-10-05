FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
        wget git unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libicu-dev \
        libpq-dev \
        zlib1g-dev \
        libzip-dev \
	    curl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install intl \
    && docker-php-ext-install shmop \
    && docker-php-ext-install -j$(nproc) exif \
    && docker-php-ext-install zip

WORKDIR /var/www

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
RUN chmod 777 /var/log
COPY conf.ini $PHP_INI_DIR/conf.d/

RUN usermod -u 1000 www-data
