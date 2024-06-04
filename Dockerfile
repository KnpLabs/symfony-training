FROM composer:2.5.8 as composer

##################################

FROM php:8.3.6-fpm-alpine3.19

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
    bash==5.2.21-r0 \
    git==2.43.4-r0 \
    icu-dev==74.1-r0

RUN mkdir -p /usr/src/app \
    && addgroup docker \
    && adduser -S -h /home/docker -u ${USER_ID:-1000} -G docker docker \
    && chown -R docker /home/docker /usr/src/app \
    && apk add --no-cache --virtual=.build-deps \
    autoconf==2.71-r2 \
    g++==13.2.1_git20231014-r0 \
    make==4.4.1-r2 \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu intl \
    && apk del .build-deps

WORKDIR /usr/src/app

COPY composer.json /usr/src/app/composer.json
COPY composer.lock /usr/src/app/composer.lock

RUN composer install --no-scripts

COPY . /usr/src/app

RUN chown -R 1000:1000 /usr/src/app
USER 1000:1000
