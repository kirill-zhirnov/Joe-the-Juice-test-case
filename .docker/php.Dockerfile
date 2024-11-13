FROM composer/composer:latest-bin as composer

FROM php:8.2-alpine as php-server
RUN apk add --update --no-cache openssl-dev linux-headers
RUN apk add --no-cache $PHPIZE_DEPS
RUN docker-php-ext-install bcmath
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .

RUN composer install

CMD [ "php", "-S", "0.0.0.0:8080", "-t", "/var/www/html/public" ]
