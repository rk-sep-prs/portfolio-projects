# Railway用Dockerfile（プロジェクト直下）
FROM thecodingmachine/php:8.2-v4-fpm

WORKDIR /app

RUN mkdir -p /app/bootstrap/cache

COPY ./src .

RUN mkdir -p /app/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080
