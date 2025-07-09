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

### Frontend（現在フェーズ）
- **Blade Templates** - Laravel標準テンプレートエンジン
- **Tailwind CSS** - ユーティリティファーストCSSフレームワーク  
- **Vite** - 高速なフロントエンドビルドツール
- **Alpine.js** - 軽量なJavaScriptフレームワーク（必要に応じて）

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

### Clean Architecture 実装指針

#### 各層の責務
1. **Domain層（最重要）**
   - ビジネスルールの中核
   - 外部に依存しない純粋なPHPクラス
   - Entity、Value Object、Repository Interface

2. **Application層**
   - ユースケースの実装
   - ドメインサービスのオーケストレーション
   - Command/Query分離（CQRS）

3. **Infrastructure層** 
   - データ永続化（Eloquent）
   - 外部API連携
   - Repository実装

4. **Presentation層**
   - HTTPリクエスト処理
   - Bladeテンプレート
   - UI関連アセット

### 新機能開発フロー

#### 1. ドメイン層から開始
```php
// 例: 新しい「読書目標」機能
app/Domain/Entities/ReadingGoal.php
app/Domain/ValueObjects/GoalPeriod.php
app/Domain/Repositories/ReadingGoalRepositoryInterface.php
```

#### 2. アプリケーション層でユースケース実装
```php
app/Application/UseCases/ReadingGoal/
├── CreateReadingGoalUseCase.php
├── UpdateProgressUseCase.php
└── CalculateAchievementUseCase.php
```

#### 3. インフラ層で永続化
```php
app/Infrastructure/Persistence/Eloquent/ReadingGoal.php
app/Infrastructure/Repositories/EloquentReadingGoalRepository.php
```

#### 4. プレゼンテーション層でUI
```php
app/Presentation/Http/Controllers/ReadingGoalController.php
app/Presentation/Views/reading-goals/
├── index.blade.php
├── create.blade.php
└── show.blade.php
```

### CQRS パターンの活用
```php
// Command例（書き込み操作）
CreateBookLogCommand    → CreateBookLogInteractor
UpdateBookLogCommand    → UpdateBookLogInteractor
DeleteBookLogCommand    → DeleteBookLogInteractor

// Query例（読み込み操作）  
ListBookLogsQuery       → ListBookLogsInteractor
FindBookLogByIdQuery    → FindBookLogByIdInteractor
SearchBookLogsQuery     → SearchBookLogsInteractor

// 実装構造
app/Application/
├── Contracts/          # 抽象クラス
│   ├── UseCase.php    # 全UseCaseの基底クラス
│   ├── Query.php      # 読み取り専用操作の基底クラス  
│   └── Command.php    # 書き込み操作の基底クラス
├── Queries/BookLog/    # CQRS読み取り操作
│   ├── ListBookLogsQuery.php
│   └── FindBookLogByIdQuery.php
├── Commands/BookLog/   # CQRS書き込み操作
│   ├── CreateBookLogCommand.php
│   └── UpdateBookLogCommand.php
└── Interactors/BookLog/ # ビジネスロジック実装
    ├── ListBookLogsInteractor.php
    ├── FindBookLogByIdInteractor.php
    ├── CreateBookLogInteractor.php
    └── UpdateBookLogInteractor.php
```

### コーディング規約
- **PSR-12準拠** - PHPコーディングスタンダード
- **型宣言の積極活用** - PHP 8.4の型システムを最大限活用
- **ドメイン駆動設計** - ユビキタス言語の使用
- **テスト駆動開発** - 各層に対応したテスト作成

### Clean Architecture学習のポイント

#### 依存関係の方向
```
Presentation → Application → Domain ← Infrastructure
              ↑___________________________|
```
- **重要**: ドメイン層は何にも依存しない
- Infrastructure層はDomain層のインターフェースに依存
- 依存性逆転の原則（DIP）を厳格に適用

#### 実装順序の推奨
1. **Domain Entity** - ビジネスオブジェクトの定義
2. **Repository Interface** - データアクセスの抽象化
3. **Use Case** - ビジネスロジックの実装
4. **Repository Implementation** - データ永続化の実装
5. **Controller** - HTTPインターフェースの実装
6. **View** - ユーザーインターフェースの実装

## 🧪 テスト戦略

### 層別テスト方針
```bash
# ドメイン層テスト（最重要）
tests/Unit/Domain/Entities/BookLogTest.php
tests/Unit/Domain/ValueObjects/IsbnTest.php

# アプリケーション層テスト
tests/Unit/Application/UseCases/CreateBookLogUseCaseTest.php

# インフラ層テスト  
tests/Integration/Infrastructure/Repositories/EloquentBookLogRepositoryTest.php

# プレゼンテーション層テスト
tests/Feature/Presentation/Http/Controllers/BookLogControllerTest.php
```

### テスト実行
```bash
# 全テスト実行
docker-compose exec php php artisan test

# 層別テスト実行
docker-compose exec php php artisan test tests/Unit/Domain/
docker-compose exec php php artisan test tests/Unit/Application/

# カバレッジレポート
docker-compose exec php php artisan test --coverage
```

## 📊 今後の拡張予定

### Phase 1: Clean Architecture習得（現在）
- [x] **基本構造構築** - 4層アーキテクチャの実装
- [x] **BookLog機能** - 基本的なCRUD操作
- [x] **CQRS実装** - Command/Query責務分離パターン
- [x] **Interactor実装** - UseCase抽象クラスとInteractor具象クラス
- [ ] **Value Object活用** - ISBN、評価、ステータスなど
- [ ] **Domain Service** - ビジネスルール強化
- [ ] **Event System** - ドメインイベントの実装

### Phase 2: 機能拡張
- [ ] **認証・認可** - Laravel Sanctum導入
- [ ] **マルチメディア対応** - アニメ、漫画、小説モデル
- [ ] **評価・レビュー** - 5段階評価とコメント
- [ ] **検索・フィルタ** - 高度な検索機能
- [ ] **統計・レポート** - 読書統計の可視化

### Phase 3: 高度な機能（将来）
- [ ] **API化** - RESTful API エンドポイント整備  
- [ ] **Next.js移行** - モダンなReactフロントエンド
- [ ] **外部API連携** - 作品情報の自動取得
- [ ] **推薦システム** - 機械学習による作品推薦
- [ ] **ソーシャル機能** - レビュー共有・フォロー

### Phase 4: インフラ強化
- [ ] **CI/CD構築** - GitHub Actions
- [ ] **監視システム** - APM導入  
- [ ] **パフォーマンス最適化** - キャッシュ戦略

## 📚 Clean Architecture 学習リソース

### 参考資料
- [Clean Architecture (Robert C. Martin)](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [Domain-Driven Design (Eric Evans)](https://domainlanguage.com/ddd/)
- [CQRS Journey (Microsoft)](https://docs.microsoft.com/en-us/azure/architecture/patterns/cqrs)

### 実装例で学ぶポイント
1. **エンティティの設計** - `app/Domain/Entities/BookLog.php`
2. **リポジトリパターン** - `app/Domain/Repositories/`と`app/Infrastructure/Repositories/`の関係
3. **CQRS実装** - `app/Application/Commands/`と`app/Application/Queries/`の分離
4. **Interactorパターン** - `app/Application/Interactors/BookLog/`でのビジネスロジック実装
5. **依存性注入** - `app/Providers/AppServiceProvider.php`でのバインディング
4. **依存性注入** - `app/Providers/AppServiceProvider.php`でのバインディング

### 段階的学習アプローチ
1. **まずはBookLogで基本を理解** - 既存実装の読解
2. **新しいValueObjectを追加** - ISBN、評価などの値オブジェクト
3. **別エンティティで応用** - Anime、Mangaエンティティの実装
4. **ドメインサービス導入** - 複雑なビジネスロジックの抽象化

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
