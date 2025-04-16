# .docker/php/Dockerfile (Debianベース, RUN分割版)

# ベースイメージを指定 (PHP 8.3 FPM, Debianベース)
FROM thecodingmachine/php:8.2-v4-fpm

# コンテナ内の作業ディレクトリを設定
WORKDIR /var/www/html

# --- パッケージ操作や拡張機能インストール前に root ユーザーに切り替え ---
    USER root

# --- RUN コマンドをステップごとに分割 ---

# ステップ1: パッケージリストを最新化
RUN apt-get update

# ステップ2: PHP拡張機能に必要なライブラリをインストール
# -y: 確認なしでインストール
# --no-install-recommends: 推奨パッケージを除外
# RUN apt-get install -y --no-install-recommends \
#         # ↓ 基本的なビルドツールを追加
#         build-essential \
#         autoconf \
#         automake \
#         libtool \
#         # ↓ 既存のライブラリとツール
#         libzip-dev \
#         libicu-dev \
#         libxml2-dev \
#         libonig-dev \
#         pkg-config \
#         bison \
#         re2c
#     # もし他のライブラリが必要になったら、このリストに追加してください

# # ステップ3: (ビルド依存パッケージのインストール - Debianでは一旦不要としています)
# # もし後で拡張機能のビルドでエラーが出たら、ここに必要な開発ツール(build-essentialなど)を追加します

# # ステップ4: PHP拡張機能の設定 (intl以外にもあれば追加)
# RUN docker-php-ext-configure intl

# # ステップ5: PHP拡張機能のインストール
# RUN docker-php-ext-install \
#         pdo_mysql \
#         mbstring \
#         tokenizer \
#         xml \
#         ctype \
#         json \
#         bcmath \
#         sockets \
#         zip \
#         intl
#     # 他に必要な拡張機能があれば、このリストに追加してください

# # ステップ6: (不要なビルド依存パッケージの削除 - スキップ)

# # ステップ7: クリーンアップ (aptキャッシュ削除)
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # --- 分割ここまで ---

# # Composerのインストール (変更なし)
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# (オプション) PHPの設定ファイル (変更なし)
# COPY ./php.ini /usr/local/etc/php/conf.d/custom-php.ini

# コンテナ起動時のデフォルトコマンド (php-fpm) はベースイメージで設定されているので通常は不要
# CMD ["php-fpm"]