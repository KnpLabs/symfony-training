FROM composer:2 AS composer

##################################

FROM php:8.4-fpm-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app

RUN addgroup docker \
    && adduser -S -h /home/docker -u 1000 -G docker docker \
    && chown -R docker /home/docker /usr/src/app \
    && apk add --no-cache --virtual=.build-deps \
        $PHPIZE_DEPS \
    && apk add --no-cache \
        bash \
        git \
        icu-dev \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install -j"$(nproc)" \
        intl \
        pdo_mysql \
    && pecl install \
        apcu \
    && docker-php-ext-enable \
        apcu \
        intl \
    && apk del .build-deps

COPY composer.* /usr/src/app/

RUN composer install --no-scripts

COPY --chown=docker:docker . /usr/src/app

USER docker
