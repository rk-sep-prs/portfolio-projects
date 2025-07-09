# Railway用Dockerfile（プロジェクト直下）
FROM thecodingmachine/php:8.2-v4-fpm

WORKDIR /app

# 先にbootstrap/cacheを作成
RUN mkdir -p /app/bootstrap/cache

COPY ./src .

# 念のため再度作成（COPYで消える場合があるため）
RUN mkdir -p /app/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# パーミッション調整（必要に応じて）
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache || true

EXPOSE 8080

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080
