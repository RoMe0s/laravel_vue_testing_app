FROM php:7.4-fpm-alpine

RUN apk add --no-cache --virtual git libintl icu icu-dev postgresql-dev g++ gcc make autoconf \
    && docker-php-ext-install intl pdo_pgsql pcntl \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 -S php && \
    adduser -u 1000 -S php -G php

USER php

EXPOSE 9000

CMD ["php-fpm"]

