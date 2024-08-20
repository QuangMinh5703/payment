FROM php:8.3-fpm-alpine

COPY composer.json /var/www/
COPY database /var/www/database

RUN apk upgrade --update && apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev supervisor tzdata git libzip-dev zip linux-headers

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Install Swoole extension
#RUN apk add --no-cache --virtual .build-deps linux-headers autoconf gcc libc-dev make g++
#RUN pecl install swoole
#RUN docker-php-ext-enable swoole

#RUN apk del .build-deps
RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

# Remove Cache
RUN rm -rf /var/cache/apk/*

RUN docker-php-ext-install sockets exif pcntl zip
RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php --\
        --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY devenv1/.docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY devenv1/.docker/supervisor/config /etc/supervisor.d

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

#TODO: Local env & production env
#ENTRYPOINT ["sh", "/var/www/.docker/entrypoint.sh"]

CMD supervisord -n -c /etc/supervisord.conf
