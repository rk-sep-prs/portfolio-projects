# Makefile for Docker Compose operations

# .PHONY: ターゲット名がファイル名と衝突するのを防ぎ、
#         常にコマンドを実行するようにするための宣言です。
.PHONY: up down build ps logs exec

# コンテナをバックグラウンドで起動します (-d: detached mode)
up:
	docker compose up -d

# コンテナを停止し、関連するコンテナ、ネットワークを削除します
# 注意: デフォルトでは名前付きボリューム (DBデータなど) は削除されません。
#       ボリュームも削除したい場合は 'docker compose down -v' にします。
down:
	docker compose down

# サービスのイメージをビルドまたは再ビルドします
build:
	docker compose build

# 起動しているコンテナの状態を表示します
ps:
	docker compose ps

# コンテナのログを表示します (-f: 追従表示, --tail=100: 最新100行)
logs:
	docker compose logs -f --tail=100

