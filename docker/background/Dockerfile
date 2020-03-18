FROM php:7.4-alpine

RUN apk add --no-cache --virtual git libintl icu icu-dev postgresql-dev g++ gcc make autoconf supervisor \
    && docker-php-ext-install intl pdo_pgsql pcntl \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis

RUN addgroup -g 1000 -S php && \
    adduser -u 1000 -S php -G php

COPY ./application.ini /etc/supervisor.d/application.ini

COPY ./scheduler.sh /usr/local/bin/scheduler.sh
RUN chmod +x /usr/local/bin/scheduler.sh

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
