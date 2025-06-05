# Clean Architecture リファクタリング計画

## 目標
Laravel フレームワークの制約を尊重しつつ、Clean Architecture 原則に基づいたディレクトリ構造を実現する。

## 現在の構造
```
app/
├── Application/           # ✅ 適切に配置済み
├── Domain/               # ✅ 適切に配置済み  
├── Http/Controllers/     # ❌ Presentation層に移動したい
├── Infrastructure/       # ✅ 適切に配置済み
├── Models/              # ❌ Infrastructure層に移動したい
├── Presentation/        # ✅ 作成済みだが未使用
└── Providers/           # Laravel固有（移動不可）

resources/                # ❌ Presentation層に統合したい
└── views/
```

## 推奨リファクタリング案

### Option 1: 段階的移行（推奨）
Laravel の制約を最小限に抑えつつ、段階的に構造を改善

```
app/
├── Application/
│   ├── UseCases/
│   ├── Commands/
│   ├── Queries/
│   └── Handlers/
├── Domain/
│   ├── Entities/
│   ├── Repositories/
│   ├── Services/
│   ├── ValueObjects/
│   └── Events/
├── Infrastructure/
│   ├── Repositories/
│   ├── External/
│   ├── Persistence/
│   │   └── Eloquent/     # Models をここに移動
│   │       └── BookLog.php
│   └── Http/             # Laravel HTTP 固有の実装
├── Presentation/
│   ├── Http/
│   │   ├── Controllers/  # Http/Controllers から移動
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   └── Views/           # resources/views から移動
│       └── (Blade templates)
├── Http/                # Laravel フレームワーク固有（残す）
│   ├── Kernel.php       # フレームワーク要求
│   └── Middleware/      # グローバルミドルウェア
└── Providers/           # Laravel 固有（変更不可）
```

### Option 2: 完全分離（上級者向け）
Laravel の制約から完全に独立した構造

```
src/
├── Application/
├── Domain/
├── Infrastructure/
│   └── Laravel/         # Laravel固有実装を分離
│       ├── Models/
│       ├── Providers/
│       └── Http/
└── Presentation/
    ├── Http/
    └── Views/

app/                     # Laravel bootstrap のみ
└── (minimal Laravel setup)
```

## 実装手順（Option 1）

### Step 1: Models の移動
```bash
# 1. Infrastructure/Persistence/Eloquent ディレクトリ作成
mkdir -p app/Infrastructure/Persistence/Eloquent

# 2. BookLog.php の移動
mv app/Models/BookLog.php app/Infrastructure/Persistence/Eloquent/

# 3. namespace 更新
# From: namespace App\Models;
# To:   namespace App\Infrastructure\Persistence\Eloquent;
```

### Step 2: Controllers の移動
```bash
# 1. Presentation/Http/Controllers 作成
mkdir -p app/Presentation/Http/Controllers

# 2. Controllers の移動
mv app/Http/Controllers/BookLogController.php app/Presentation/Http/Controllers/

# 3. namespace 更新
# From: namespace App\Http\Controllers;
# To:   namespace App\Presentation\Http\Controllers;
```

### Step 3: Views の移動
```bash
# 1. Presentation/Views 作成
mkdir -p app/Presentation/Views

# 2. Views の移動
mv resources/views/* app/Presentation/Views/

# 3. View パス設定更新 (AppServiceProvider)
```

### Step 4: Composer オートロード更新
```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "App\\Infrastructure\\Persistence\\Eloquent\\": "app/Infrastructure/Persistence/Eloquent/",
            "App\\Presentation\\": "app/Presentation/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

### Step 5: Laravel 設定の更新

#### config/view.php
```php
'paths' => [
    resource_path('views'),
    app_path('Presentation/Views'),  // 追加
],
```

#### app/Providers/AppServiceProvider.php
```php
public function boot()
{
    // View パスの設定
    $this->app['view']->addLocation(app_path('Presentation/Views'));
    
    // Repository バインディング
    $this->app->bind(
        \App\Domain\Repositories\BookLogRepositoryInterface::class,
        \App\Infrastructure\Repositories\EloquentBookLogRepository::class
    );
}
```

#### routes/web.php
```php
// namespace 更新
use App\Presentation\Http\Controllers\BookLogController;
```

## メリット

### Option 1
- ✅ Laravel フレームワークとの互換性保持
- ✅ 段階的移行が可能
- ✅ 既存チームの学習コストが低い
- ✅ Laravel エコシステムとの統合が容易

### Option 2  
- ✅ 完全な Clean Architecture 実装
- ✅ フレームワーク非依存
- ✅ テストが容易
- ❌ Laravel の恩恵を受けにくい
- ❌ 設定が複雑

## 推奨事項

**Option 1** を推奨します。理由：

1. **実用性**: Laravel の制約内で最大限の Clean Architecture を実現
2. **互換性**: 既存の Laravel エコシステムとの統合が容易
3. **保守性**: チーム全体の理解と保守が現実的
4. **移行リスク**: 段階的移行でリスクを最小化

## 注意点

1. **Eloquent モデルの移動**: Laravel の Model クラスを Infrastructure 層に移動する場合、適切な Repository パターンでラップする
2. **View パス設定**: Laravel の View システムに新しいパスを適切に設定する
3. **オートロード**: Composer の PSR-4 オートロードを正しく設定する
4. **IDE サポート**: PhpStorm/VSCode のオートコンプリートが正しく動作するよう設定する

## 実装後の検証

- [ ] `composer dump-autoload` の実行
- [ ] 全ユニットテストの通過
- [ ] アプリケーションの正常動作確認
- [ ] IDE のオートコンプリート動作確認
