# syntax=docker/dockerfile:1

FROM wordpress:7.0.1-php8.4-fpm AS base

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libzip-dev \
        unzip \
    ; \
    docker-php-ext-install -j"$(nproc)" \
        intl \
        bcmath \
        zip \
    ; \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 \
    /usr/bin/composer \
    /usr/local/bin/composer

# COPY docker/php/conf.d/common.ini \
#     /usr/local/etc/php/conf.d/50-common.ini

# COPY docker/php/fpm.d/common.conf \
#     /usr/local/etc/php-fpm.d/50-common.conf


# FROM base AS development

# RUN set -eux; \
#     pecl install xdebug; \
#     docker-php-ext-enable xdebug

# COPY docker/php/conf.d/development.ini \
#     /usr/local/etc/php/conf.d/90-environment.ini

# COPY docker/php/fpm.d/development.conf \
#     /usr/local/etc/php-fpm.d/90-environment.conf

# WORKDIR /var/www/html


# FROM base AS production

# COPY docker/php/conf.d/production.ini \
#     /usr/local/etc/php/conf.d/90-environment.ini

# COPY docker/php/fpm.d/production.conf \
#     /usr/local/etc/php-fpm.d/90-environment.conf

# WORKDIR /var/www/html