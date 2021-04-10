FROM composer:1.6
FROM php:7.3-fpm-alpine

RUN apk add --no-cache \
    libpng \
    libpng-dev \
    libzip-dev \
    bash

RUN docker-php-ext-install -j$(nproc) \
    gd \
    zip \
    pdo_mysql

RUN apk del libpng-dev

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=0 /usr/bin/composer /usr/bin/composer
RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative

WORKDIR /var/www
COPY ./ /var/www

RUN composer install --prefer-dist --no-progress --no-suggest