FROM php:8.4-cli-alpine
RUN apk add --no-cache $PHPIZE_DEPS linux-headers build-base autoconf rabbitmq-c-dev \
    && pecl install xdebug amqp \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable xdebug mysqli pdo pdo_mysql amqp