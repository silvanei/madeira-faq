FROM php:7.4.0-fpm-alpine3.10

# https://snyk.io/blog/10-docker-image-security-best-practices/
# Teste da imagem https://medium.com/@aelsabbahy/tutorial-how-to-test-your-docker-image-in-half-a-second-bbd13e06a4a9
LABEL maintanier="ads.silvanei@gmail.com"
LABEL alpine-package-version="https://pkgs.alpinelinux.org/packages?name=nginx&branch=v3.10&repo=main&arch=x86"
LABEL find-opcache-max-accelerated-files="find . -type f -print | grep php | wc -l"

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_OPCACHE_MAX_ACCELERATED_FILES=7601 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=128 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_INSTAL=1 \
    COMPOSER_INSTALL_PARANS="--prefer-dist --no-scripts --no-dev --optimize-autoloader" \
    TZ="America/Sao_Paulo"

COPY docker/php/999-custom.ini /usr/local/etc/php/conf.d/999-custom.ini

RUN set -e \
    && apk update --no-cache \
    && apk add --no-cache tzdata=2019c-r0 \
    && apk add --no-cache icu-dev=64.2-r0 \
    && apk add --no-cache libzip-dev=1.5.2-r0 \
    && apk add --no-cache g++=8.3.0-r0 \
    && apk add --no-cache make=4.2.1-r2 \
    && apk add --no-cache autoconf=2.69-r2 \
    # Dependencias php
    && docker-php-ext-install \
        pdo_mysql \
        opcache \
        intl \
    && pecl install xdebug \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require hirak/prestissimo \
    #   Clear install
    && pecl clear-cache \
    && composer clear-cache \
    && docker-php-source delete \
    && rm -rf /var/cache/* \
    && rm -Rf /tmp/*

# Variáveis de ambiente na configuração do container
RUN sed -e 's/;clear_env = no/clear_env = no/' -i /usr/local/etc/php-fpm.d/www.conf

COPY . /var/www/default

WORKDIR /var/www/default

COPY docker/php/docker-php-start.sh /usr/local/bin/docker-php-start
RUN ["chmod", "+x", "/usr/local/bin/docker-php-start"]

CMD ["/usr/local/bin/docker-php-start"]
