FROM php:7.4-fpm-alpine

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git
RUN docker-php-ext-install pdo pdo_mysql

# Need to add a default value to use it through the command line
ARG UID='1000'

RUN touch /home/www-data/.bashrc | echo "PS1='\w\$ '" >> /home/www-data/.bashrc

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.9.6 \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u $UID www-data

WORKDIR /var/www

RUN rm -rf /var/www/html

RUN ln -s public html

USER www-data

EXPOSE 80

ENTRYPOINT ["php-fpm"]
