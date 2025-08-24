<?php

declare(strict_types=1);

namespace App\Application\DTOs\BookLogs\Output;

use App\Domain\ValueObjects\BookTitle;
use App\Domain\ValueObjects\BookRating;

/**
 * BookLogレスポンスDTO（出力用）
 */
class BookLogResponseDTO
{
    public function __construct(
        public readonly string $id,
        public readonly BookTitle $title,
        public readonly string $author,
        public readonly ?string $description,
        public readonly ?string $readAt,
        public readonly ?BookRating $rating,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }

    // ビジネスロジックの例
    public function getTitleAsString(): string
    {
        return $this->title->value();
    }

    public function getRatingAsInt(): ?int
    {
        return $this->rating?->value();
    }

    public function isHighRated(): bool
    {
        return $this->rating && $this->rating->isHighRating();
    }
}
