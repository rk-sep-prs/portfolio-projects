<?php

declare(strict_types=1);

namespace App\Application\DTOs\BookLogs\Output;

/**
 * BookLogレスポンスDTO（出力用）
 * プレゼンテーション層で使いやすい形式にデータを変換
 */
class BookLogResponseDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,        // 値オブジェクトではなく文字列
        public readonly string $author,
        public readonly ?string $description,
        public readonly ?string $readAt,      // フォーマット済みの文字列
        public readonly ?int $rating,         // 値オブジェクトではなく整数
        public readonly ?string $createdAt,   // フォーマット済みの文字列
        public readonly ?string $updatedAt,   // フォーマット済みの文字列
    ) {
    }

    // ビジネスロジックの例
    public function isHighRated(): bool
    {
        return $this->rating !== null && $this->rating >= 8;
    }

    public function isRecentlyRead(): bool
    {
        if (!$this->readAt) {
            return false;
        }

        $readDate = new \DateTimeImmutable($this->readAt);
        $thirtyDaysAgo = new \DateTimeImmutable('-30 days');
        return $readDate > $thirtyDaysAgo;
    }

    // エンティティからDTOを作成するファクトリメソッド
    // ここでエンティティの値オブジェクトをプリミティブ型に変換
    public static function fromEntity(\App\Domain\BookLog\Entities\BookLog $bookLog): self
    {
        return new self(
            id: $bookLog->id,
            title: $bookLog->title->value(),                    // 値オブジェクトから文字列を取得
            author: $bookLog->author,
            description: $bookLog->description,
            readAt: $bookLog->readAt?->format('Y-m-d H:i:s'),  // DateTimeImmutableを文字列に変換
            rating: $bookLog->rating?->value(),                 // 値オブジェクトから整数を取得
            createdAt: $bookLog->createdAt?->format('Y-m-d H:i:s'),
            updatedAt: $bookLog->updatedAt?->format('Y-m-d H:i:s'),
        );
    }
}
