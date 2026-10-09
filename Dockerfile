FROM php:8.4-fpm-alpine
RUN apk add --no-cache bash icu-dev libzip-dev oniguruma-dev mysql-client nodejs npm $PHPIZE_DEPS && docker-php-ext-install pdo_mysql mbstring intl bcmath opcache
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan optimize
RUN chown -R www-data:www-data storage bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
