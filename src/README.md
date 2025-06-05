# 📚 記録管理アプリケーション

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Architecture-Clean-00D9FF?style=for-the-badge" alt="Clean Architecture">
  <img src="https://img.shields.io/badge/Pattern-CQRS-purple?style=for-the-badge" alt="CQRS">
  <img src="https://img.shields.io/badge/DDD-Domain%20Driven-green?style=for-the-badge" alt="DDD">
</p>

## 🎯 プロジェクト概要

本アプリケーションは、様々なメディア作品の記録を一元管理する**記録管理システム**です。
読書、アニメ視聴、漫画読了、小説読破など、あなたの文化的体験を体系的に記録・管理できます。

### 📖 対応メディア

- **📚 書籍** - 小説、技術書、ビジネス書、エッセイなど
- **🎬 アニメ** - TVシリーズ、映画、OVAなど
- **📝 漫画** - 連載作品、単発作品、Webコミックなど
- **✍️ 小説** - ライトノベル、Web小説、純文学など

### ✨ 主な機能

- 📝 作品情報の登録・管理
- 📊 読了・視聴状況の追跡
- 💭 感想・レビューの記録
- 📈 統計情報の可視化
- 🔍 高度な検索・フィルタリング

## 🏗️ アーキテクチャ・設計思想

本プロジェクトは、保守性・拡張性・テスタビリティを重視し、以下の設計原則を採用しています：

### 🧱 Clean Architecture
```
┌─────────────────────────────────────────────┐
│                Presentation                 │  ← UI層・コントローラー
├─────────────────────────────────────────────┤
│                Application                  │  ← ユースケース・ビジネスロジック
├─────────────────────────────────────────────┤
│                  Domain                     │  ← エンティティ・ドメインサービス
├─────────────────────────────────────────────┤
│               Infrastructure                │  ← データベース・外部API
└─────────────────────────────────────────────┘
```

### ⚡ CQRS (Command Query Responsibility Segregation)
- **Command**: データ変更操作を責務とする
- **Query**: データ参照操作を責務とする
- 読み書きの責務を明確に分離し、パフォーマンスと保守性を向上

### 🎯 DDD (Domain Driven Design)
- ドメインエキスパートとの共通言語（ユビキタス言語）の構築
- ビジネスロジックをドメイン層に集約
- 複雑なビジネスルールを表現力豊かにモデリング

## 🛠️ 技術スタック

## 🛠️ 技術スタック

### Backend
- **PHP 8.4** - 最新の型システムとパフォーマンス改善を活用
- **Laravel 11.x** - エレガントなWeb開発フレームワーク
- **MySQL 8.4** - リレーショナルデータベース

### Frontend
- **Vite** - 高速なフロントエンドビルドツール
- **Tailwind CSS** - ユーティリティファーストCSSフレームワーク
- **Blade Templates** - Laravel標準テンプレートエンジン

### Infrastructure
- **Docker** - コンテナ化による開発環境統一
- **Docker Compose** - 複数サービスのオーケストレーション

## 📁 プロジェクト構造

```
app/
├── Application/           # アプリケーション層
│   ├── Commands/         # コマンド（書き込み操作）
│   ├── Handlers/         # コマンドハンドラー
│   ├── Queries/          # クエリ（読み込み操作）
│   └── UseCases/         # ユースケース実装
├── Domain/               # ドメイン層
│   ├── Entities/         # エンティティ
│   ├── Events/           # ドメインイベント
│   ├── Repositories/     # リポジトリインターフェース
│   ├── Services/         # ドメインサービス
│   └── ValueObjects/     # 値オブジェクト
├── Infrastructure/       # インフラストラクチャ層
│   ├── External/         # 外部API連携
│   ├── Persistence/      # データ永続化
│   │   └── Eloquent/     # Eloquentモデル
│   └── Repositories/     # リポジトリ実装
└── Presentation/         # プレゼンテーション層
    ├── Assets/           # CSS, JavaScript
    ├── Http/            
    │   └── Controllers/  # HTTPコントローラー
    └── Views/            # Bladeテンプレート
```

## 🚀 セットアップ・起動方法

### 前提条件
- Docker & Docker Compose
- Git

### 1. リポジトリのクローン
```bash
git clone <repository-url>
cd laravel-practice
```

### 2. 環境設定
```bash
# 環境変数ファイルのコピー
cp src/.env.example src/.env

# 必要に応じて .env を編集
```

### 3. Docker環境の起動
```bash
# コンテナのビルド・起動
docker-compose up -d

# 依存関係のインストール
docker-compose exec php composer install
docker-compose exec php npm install

# アプリケーションキーの生成
docker-compose exec php php artisan key:generate

# データベースマイグレーション
docker-compose exec php php artisan migrate

# サンプルデータの投入（任意）
docker-compose exec php php artisan db:seed
```

### 4. フロントエンドアセットのビルド
```bash
# 開発用（ウォッチモード）
npm run dev

# 本番用
npm run build
```

### 5. アプリケーションアクセス
- **Web Application**: http://localhost:8080
- **Database**: localhost:3306

## 🎯 開発ガイドライン

### ディレクトリ配置規則

#### 新機能追加時
1. **ドメイン層**: ビジネスルールとエンティティを定義
2. **アプリケーション層**: ユースケースを実装
3. **インフラ層**: データ永続化を実装
4. **プレゼンテーション層**: UIとAPI エンドポイントを実装

#### CQRS パターン
```php
// Command例（書き込み）
CreateBookLogCommand
CreateBookLogHandler

// Query例（読み込み）
ListBookLogsQuery  
ListBookLogsHandler
```

### コーディング規約
- PSR-12準拠
- 型宣言の積極的活用
- ドメイン駆動設計の原則遵守

## 🧪 テスト

```bash
# 全テスト実行
docker-compose exec php php artisan test

# 特定テストの実行
docker-compose exec php php artisan test --filter=BookLogTest

# カバレッジレポート生成
docker-compose exec php php artisan test --coverage
```

## 📊 今後の拡張予定

- [ ] **認証機能** - ユーザー管理・ログイン機能
- [ ] **API化** - RESTful API / GraphQL対応
- [ ] **検索機能強化** - Elasticsearch導入
- [ ] **推薦システム** - 機械学習による作品推薦
- [ ] **ソーシャル機能** - レビュー共有・フォロー機能
- [ ] **外部API連携** - 作品情報の自動取得

## 🤝 コントリビューション

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 ライセンス

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 謝辞

- [Laravel Framework](https://laravel.com) - 素晴らしいWebフレームワーク
- [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html) - Robert C. Martin氏の設計思想
- コミュニティの皆様の貴重なフィードバック
