FROM php:8.1-fpm
RUN set -x \
    && apt-get update \
    && apt-get -yq install \
        bash \
    && apt-get -yq clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && mkdir -p /usr/src/php/ext \
    && bash --version \
    && docker-php-ext-install \
        sysvsem \
        mysqli \
        pdo_mysql \
        sysvshm \
        bcmath \
        sockets

# Install xDebug
RUN pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug

COPY ./php.ini /usr/local/etc/php/conf.d/fb_friends.ini