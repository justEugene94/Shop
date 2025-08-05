FROM php:7.2-cli-alpine

RUN apk --update add libpng-dev libjpeg-turbo-dev freetype-dev wget curl git php php-curl php-openssl php-json php-phar php-dom zlib-dev zip gd && rm /var/cache/apk/*

RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install -j$(nproc) exif \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install -j$(nproc) pdo_mysql


RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

RUN apk add --no-cache nodejs npm

RUN apk add --no-cache bash ffmpeg

ENV NPM_CONFIG_CACHE=/tmp/.npm
ENV HOME=/tmp

RUN mkdir -p /tmp/.npm /tmp/.config \
    && chmod -R 777 /tmp/.npm /tmp/.config \
    && echo 'cache=/tmp/.npm' > /etc/npmrc

WORKDIR /var/www

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow
