FROM php:8.1.4-fpm

#COPY ./php-dev.ini "$PHP_INI_DIR/php.ini"

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php composer-setup.php --install-dir=/bin --filename=composer && php -r "unlink('composer-setup.php');"

RUN apt update && apt install -y unzip libpq-dev less bzip2 vim procps git libicu-dev libfreetype6-dev libwebp-dev libjpeg-dev\
    libpng-dev libxpm-dev libxml2-dev libzip-dev bzip2 libbz2-dev libffi-dev libxslt-dev &&\
    docker-php-ext-configure gd --with-jpeg --with-xpm --with-freetype --with-webp &&\
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install intl opcache shmop pcntl gd simplexml zip bcmath bz2 calendar exif ffi \
    gettext mysqli pdo_mysql sockets sysvmsg sysvsem sysvshm xsl pgsql pdo_pgsql && \
    docker-php-ext-enable opcache && \
    printf '\n' | pecl install redis && printf '\n' | pecl install apcu && docker-php-ext-enable redis apcu

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/
RUN rm -rf /var/www/html /var/www/web

CMD ["php-fpm", "-R"]