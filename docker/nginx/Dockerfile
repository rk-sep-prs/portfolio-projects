# ベースイメージを指定 (Nginx 1.26, Alpine Linux)
# Nginxの安定版(stable)で、Alpineベースの軽量なイメージを使います
FROM nginx:1.26-alpine

# (オプション) ベースイメージに含まれるデフォルト設定を削除しておくと、
# 意図しない設定が読み込まれるのを防げます。
# RUN rm /etc/nginx/conf.d/default.conf

# ホスト側（このDockerfileと同じディレクトリ）にある 'default.conf' ファイルを
# コンテナ内の '/etc/nginx/conf.d/' ディレクトリにコピーします。
# Nginxは起動時にこのディレクトリ内の .conf ファイルを自動的に読み込みます。
COPY ./default.conf /etc/nginx/conf.d/default.conf

# コンテナが公開するポート (オプション)
# docker-compose.yml の 'ports' で実際にホストと接続するポートを指定するため、
# DockerfileでのEXPOSEは必須ではありませんが、ドキュメントとして記述することがあります。
# EXPOSE 80