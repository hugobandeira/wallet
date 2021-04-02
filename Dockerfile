FROM php:7.4-fpm-alpine
RUN apk add --no-cache shadow openssl bash mysql-client nginx nano
#COPY .docker/supervisord.conf /etc/supervisord.conf
#RUN apk add --no-cache shadow openssl bash mysql-client alpine-sdk autoconf nano nginx openrc
#RUN apk add --no-cache shadow openssl bash mysql-client alpine-sdk autoconf nano nginx openrc supervisor sqlite

# Need to add a default value to use it through the command line
ARG UID='1000'

RUN docker-php-ext-install pdo pdo_mysql bcmath
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

WORKDIR /var/www
RUN rm -rf /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN ln -s public html

RUN rm /etc/nginx/conf.d/default.conf
COPY .docker/nginx/nginx.conf /etc/nginx/conf.d
COPY . .

RUN usermod -u $UID www-data
RUN chmod -R 775 /var/www/storage
RUN chown -R www-data:www-data /var/www/

USER www-data
EXPOSE 80

ENTRYPOINT ["php-fpm"]
