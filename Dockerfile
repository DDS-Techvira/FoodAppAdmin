FROM php:7.4-fpm-alpine

RUN apk --update add curl supervisor nginx

RUN apk add oniguruma-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring && docker-php-ext-enable pdo_mysql
RUN rm /var/cache/apk/*

COPY php.ini-production /usr/local/etc/php/php.ini

COPY . /var/www/html/
RUN touch /var/www/html/core/storage/logs/laravel.log
RUN chmod -R 777 /var/www/html/core/storage/
RUN chmod -R 777 /var/www/html/core/bootstrap/cache/

# RUN perl -pi -e 's#^(?=access\.log\b)#;#' /usr/local/etc/php-fpm.d/docker.conf

WORKDIR /var/www/html/core/
RUN wget https://getcomposer.org/download/latest-stable/composer.phar
RUN php composer.phar install

COPY supervisord.conf /etc/supervisord.conf
COPY supervisord-app.conf /etc/supervisor/conf.d/supervisord-app.conf

COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord-web.conf /etc/supervisor/conf.d/supervisord-web.conf

RUN echo '* * * * * cd /var/www/html/ && php artisan schedule:run > /dev/stdout' > /etc/crontabs/root

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
