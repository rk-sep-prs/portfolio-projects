# Makefile for Docker Compose operations

# .PHONY: ターゲット名がファイル名と衝突するのを防ぎ、
#         常にコマンドを実行するようにするための宣言です。
.PHONY: up down build ps logs exec install fresh migrate seed \
        test test-unit test-feature test-coverage test-domain test-app test-infra test-presentation \
        test-watch test-parallel test-filter test-verbose test-debug \
        cache-clear config-clear route-clear view-clear clear-all \
        composer-install composer-update artisan tinker pint format \
        npm-install npm-dev npm-build npm-watch \
        db-fresh db-reset queue-work queue-restart \
        ide-helper docs check-security

# === Docker操作 ===

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

# ログを表示します (-f: 追従表示, --tail=100: 最新100行)
logs:
	docker compose logs -f --tail=100

# 特定のサービスのログのみ表示
logs-php:
	docker compose logs -f php

logs-mysql:
	docker compose logs -f mysql

logs-nginx:
	docker compose logs -f nginx

# Laravel の application log を確認
logs-laravel:
	docker compose exec php tail -f storage/logs/laravel.log

# エラーログのみ表示
logs-error:
	docker compose exec php grep -i error storage/logs/laravel.log | tail -20

# PHPコンテナにアクセスして任意のコマンドを実行します
exec:
	docker compose exec php bash

# === セットアップ・初期化 ===

# プロジェクトの初期セットアップ（依存関係インストール + DB初期化）
install: composer-install npm-install
	docker compose exec php php artisan key:generate
	docker compose exec php php artisan migrate
	docker compose exec php php artisan db:seed

# 完全リフレッシュ（DB削除＋再構築＋シーダー実行）
fresh:
	docker compose exec php php artisan migrate:fresh --seed

# データベースマイグレーション実行
migrate:
	docker compose exec php php artisan migrate

# シーダー実行
seed:
	docker compose exec php php artisan db:seed

# === テスト関連 ===

# 全テスト実行
test:
	docker compose exec php php artisan test

# ユニットテストのみ実行
test-unit:
	docker compose exec php php artisan test tests/Unit/

# フィーチャーテストのみ実行
test-feature:
	docker compose exec php php artisan test tests/Feature/

# テストカバレッジ付きで実行
test-coverage:
	docker compose exec php php artisan test --coverage

# ドメイン層のテスト実行
test-domain:
	docker compose exec php php artisan test tests/Unit/Domain/

# アプリケーション層のテスト実行
test-app:
	docker compose exec php php artisan test tests/Unit/Application/

# インフラストラクチャ層のテスト実行
test-infra:
	docker compose exec php php artisan test tests/Integration/Infrastructure/

# プレゼンテーション層のテスト実行
test-presentation:
	docker compose exec php php artisan test tests/Feature/Presentation/

# PHPUnitを直接実行（より詳細な出力）
test-phpunit:
	docker compose exec php ./vendor/bin/phpunit

# Clean Architecture各層のテストを順次実行
test-layers: test-domain test-app test-infra test-presentation

# ファイル変更監視でテスト自動実行
test-watch:
	docker compose exec php php artisan test --watch

# 並列テスト実行（高速化）
test-parallel:
	docker compose exec php php artisan test --parallel

# 特定のテストファイル/メソッドのみ実行（例: make test-filter FILTER="BookLogTest"）
test-filter:
	docker compose exec php php artisan test --filter=$(FILTER)

# 詳細な出力でテスト実行
test-verbose:
	docker compose exec php php artisan test -v

# デバッグ情報付きテスト実行
test-debug:
	docker compose exec php php artisan test --debug

# 失敗したテストのみ再実行
test-retry:
	docker compose exec php php artisan test --retry

# 特定のパスでテスト実行（例: make test-path PATH="tests/Unit/Application"）
test-path:
	docker compose exec php php artisan test $(PATH)

# ===  テストヘルパー（よく使うテストの短縮コマンド） ===

# BookLogに関連するテストのみ実行
test-booklog:
	docker compose exec php php artisan test --filter=BookLog

# Interactorのテストのみ実行
test-interactors:
	docker compose exec php php artisan test tests/Unit/Application/Interactors/

# Queryのテストのみ実行
test-queries:
	docker compose exec php php artisan test tests/Unit/Application/Queries/

# Commandのテストのみ実行
test-commands:
	docker compose exec php php artisan test tests/Unit/Application/Commands/

# 新しく追加したテストのみ実行（git diff based）
test-new:
	@echo "🔍 Running tests for recently modified files..."
	docker compose exec php php artisan test --dirty

# 失敗したテストの詳細表示
test-fails:
	docker compose exec php php artisan test --stop-on-failure -v

# === キャッシュクリア関連 ===

# アプリケーションキャッシュクリア
cache-clear:
	docker compose exec php php artisan cache:clear

# 設定キャッシュクリア
config-clear:
	docker compose exec php php artisan config:clear

# ルートキャッシュクリア
route-clear:
	docker compose exec php php artisan route:clear

# ビューキャッシュクリア
view-clear:
	docker compose exec php php artisan view:clear

# オートローダーリセット
autoload-clear:
	docker compose exec php composer dump-autoload

# 全キャッシュクリア（開発時によく使う）
clear-all: cache-clear config-clear route-clear view-clear autoload-clear
	@echo "🧹 All caches cleared!"

# === Composer関連 ===

# Composer依存関係インストール
composer-install:
	docker compose exec php composer install

# Composer依存関係更新
composer-update:
	docker compose exec php composer update

# オートローダー最適化
composer-optimize:
	docker compose exec php composer dump-autoload --optimize

# === Artisan関連 ===

# Artisanコマンド実行（例: make artisan ARGS="route:list"）
artisan:
	docker compose exec php php artisan $(ARGS)

# Tinker起動（インタラクティブシェル）
tinker:
	docker compose exec php php artisan tinker

# ルート一覧表示
routes:
	docker compose exec php php artisan route:list

# === データベース関連 ===

# データベース完全リセット（fresh + seed）
db-fresh:
	docker compose exec php php artisan migrate:fresh --seed

# データベースリセット（rollback + migrate + seed）
db-reset:
	docker compose exec php php artisan migrate:reset
	docker compose exec php php artisan migrate
	docker compose exec php php artisan db:seed

# データベースステータス確認
db-status:
	docker compose exec php php artisan migrate:status

# === キュー関連 ===

# キューワーカー起動
queue-work:
	docker compose exec php php artisan queue:work

# キューワーカー再起動
queue-restart:
	docker compose exec php php artisan queue:restart

# 失敗したジョブ確認
queue-failed:
	docker compose exec php php artisan queue:failed

# === 開発支援ツール ===

# IDE Helper生成（PhpStorm等のIDE支援）
ide-helper:
	docker compose exec php php artisan ide-helper:generate
	docker compose exec php php artisan ide-helper:models
	docker compose exec php php artisan ide-helper:meta

# API documentation生成
docs:
	docker compose exec php php artisan l5-swagger:generate

# セキュリティチェック
check-security:
	docker compose exec php composer audit

# 依存関係の脆弱性チェック
security-check:
	docker compose exec php composer audit --format=table

# === デバッグ関連 ===

# アプリケーション情報表示
debug-info:
	docker compose exec php php artisan about

# 環境設定確認
debug-env:
	docker compose exec php php artisan env

# 設定値確認
debug-config:
	docker compose exec php php artisan config:show

# サービス提供者確認
debug-providers:
	docker compose exec php php artisan provider:show

# イベントリスナー確認
debug-events:
	docker compose exec php php artisan event:list

# ルートキャッシュの詳細確認
debug-routes:
	docker compose exec php php artisan route:list --verbose

# === コード品質関連 ===

# Laravel Pintでコード整形
pint:
	docker compose exec php ./vendor/bin/pint

# コードフォーマット（Pintのエイリアス）
format: pint

# PHPStan静的解析実行
analyze:
	docker compose exec php ./vendor/bin/phpstan analyse

# PHP CS Fixer実行
cs-fix:
	docker compose exec php ./vendor/bin/php-cs-fixer fix

# 全コード品質チェック実行
quality-check: pint analyze
	@echo "✅ Code quality check completed!"

# === フロントエンド関連 ===

# NPM依存関係インストール
npm-install:
	docker compose exec php npm install

# 開発用アセットビルド
npm-dev:
	docker compose exec php npm run dev

# 本番用アセットビルド
npm-build:
	docker compose exec php npm run build

# ファイル監視モード（開発時）
npm-watch:
	docker compose exec php npm run dev

# === 開発支援 ===

# 開発環境の完全リセット
dev-reset: down clear-all
	docker compose up -d
	make fresh
	@echo "🚀 Development environment reset complete!"

# 新機能開発時のセットアップ
dev-setup: up composer-install npm-install db-fresh ide-helper
	@echo "🎯 Development setup complete!"

# CI/CD環境での自動テスト
ci-test: composer-install
	docker compose exec php php artisan test --coverage --parallel
	make quality-check
	@echo "✅ CI tests completed!"

# デプロイ前チェック
pre-deploy: quality-check test security-check
	@echo "🚀 Pre-deployment checks passed!"

# よく使うコマンドのヘルプ表示
help:
	@echo "📚 Available commands:"
	@echo ""
	@echo "🐳 Docker:"
	@echo "  make up            - Start containers"
	@echo "  make down          - Stop containers"
	@echo "  make ps            - Show container status"
	@echo "  make logs          - Show container logs"
	@echo "  make exec          - Access PHP container"
	@echo ""
	@echo "🛠️  Setup:"
	@echo "  make install       - Initial project setup"
	@echo "  make fresh         - Fresh database with seeders"
	@echo "  make migrate       - Run migrations"
	@echo "  make seed          - Run seeders"
	@echo ""
	@echo "🧪 Testing:"
	@echo "  make test          - Run all tests"
	@echo "  make test-unit     - Run unit tests only"
	@echo "  make test-feature  - Run feature tests only"
	@echo "  make test-coverage - Run tests with coverage"
	@echo "  make test-watch    - Run tests in watch mode"
	@echo "  make test-parallel - Run tests in parallel"
	@echo "  make test-filter FILTER=name - Run specific test"
	@echo "  make test-domain   - Run domain layer tests"
	@echo "  make test-app      - Run application layer tests"
	@echo "  make test-layers   - Run all layer tests sequentially"
	@echo ""
	@echo "🗄️  Database:"
	@echo "  make db-fresh      - Fresh migration with seed"
	@echo "  make db-reset      - Reset database completely"
	@echo "  make db-status     - Show migration status"
	@echo ""
	@echo "📊 Queue:"
	@echo "  make queue-work    - Start queue worker"
	@echo "  make queue-restart - Restart queue worker"
	@echo "  make queue-failed  - Show failed jobs"
	@echo ""
	@echo "🧹 Cache:"
	@echo "  make clear-all     - Clear all caches"
	@echo "  make cache-clear   - Clear application cache"
	@echo "  make config-clear  - Clear config cache"
	@echo ""
	@echo "📦 Dependencies:"
	@echo "  make composer-install - Install PHP dependencies"
	@echo "  make npm-install      - Install Node dependencies"
	@echo ""
	@echo "🎨 Code Quality:"
	@echo "  make format        - Format code with Pint"
	@echo "  make analyze       - Run PHPStan analysis"
	@echo "  make quality-check - Run all quality checks"
	@echo "  make check-security - Security audit"
	@echo ""
	@echo "🚀 Development:"
	@echo "  make dev-reset     - Complete dev environment reset"
	@echo "  make routes        - Show all routes"
	@echo "  make tinker        - Start Laravel Tinker"
	@echo "  make ide-helper    - Generate IDE helpers"
	@echo ""
	@echo "📝 Examples:"
	@echo "  make test-filter FILTER=BookLogTest"
	@echo "  make test-path PATH=tests/Unit/Application"
	@echo "  make artisan ARGS=\"make:controller UserController\""

# デフォルトターゲット（make コマンドのみで実行）
default: help

phpstan:
	docker compose exec php ./vendor/bin/phpstan analyse --memory-limit=1G --configuration=phpstan.neon

