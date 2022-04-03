FROM php:8.1-apache

# ext: mysql pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql mysqli && \
    docker-php-ext-enable pdo pdo_mysql mysqli

# ext: xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# config files
COPY .docker/php /usr/local/etc/php/conf.d
