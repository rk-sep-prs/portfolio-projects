<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories; // 名前空間を確認

// 実装するインターフェースと、使用するエンティティを use
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log; // 動作確認用にLogを追加 (任意)

// App\Models\BookLog as BookLogModel; // 後で使う Eloquent モデル (今はコメントアウト)

// インターフェースを implements キーワードで実装する
class EloquentBookLogRepository implements BookLogRepositoryInterface
{
    // Eloquent モデルを操作するために、後でコンストラクタで注入したりします
    // public function __construct(private readonly BookLogModel $bookLogModel) {}

    /**
     * {@inheritdoc}
     */
    public function findAll(): Collection
    {
        // ★今はまだDBアクセスは実装しない。空のコレクションを返すだけ。
        Log::info('EloquentBookLogRepository@findAll が呼ばれました！'); // 動作確認用ログ (任意)
        return new Collection();
        // TODO: 後で Eloquent を使ってデータを取得し、BookLogエンティティのコレクションに変換する処理を実装
        // 例: return BookLogModel::all()->map(fn($model) => $this->toEntity($model));
    }

    /**
     * {@inheritdoc}
     */
    public function findById(string $id): ?BookLog
    {
        // ★今はまだDBアクセスは実装しない。常に null を返す。
        Log::info("EloquentBookLogRepository@findById ({$id}) が呼ばれました！"); // 動作確認用ログ (任意)
        return null;
        // TODO: 後で Eloquent を使ってデータを取得し、BookLogエンティティに変換する処理を実装
        // 例: $model = BookLogModel::find($id); return $model ? $this->toEntity($model) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BookLog $bookLog): void
    {
        // ★今はまだDBアクセスは実装しない。何もしない。
        Log::info("EloquentBookLogRepository@save ({$bookLog->id}) が呼ばれました！"); // 動作確認用ログ (任意)
        // TODO: 後で BookLogエンティティから Eloquent モデルにデータを詰め替え、保存する処理を実装
        // 例: BookLogModel::updateOrCreate(['id' => $bookLog->id], $this->toArray($bookLog));
    }

    // --- Helper methods for mapping (後で実装) ---
    // private function toEntity(BookLogModel $model): BookLog { /* ... */ }
    // private function toArray(BookLog $entity): array { /* ... */ }
}