ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN apk update; \
    apk upgrade;

RUN docker-php-ext-install mysqli


RUN pecl bundle -d /usr/src/php/ext redis \
&& rm /usr/src/php/ext/redis-*.tgz \
&& docker-php-ext-install redis \
&& docker-php-ext-enable redis
