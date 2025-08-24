<?php

declare(strict_types=1);

namespace App\Domain\BookLog\Entities;

use App\Domain\BookLog\ValueObjects\BookTitle;
use App\Domain\BookLog\ValueObjects\BookRating;
use DateTimeImmutable;

class BookLog
{
    public function __construct(
        public readonly string $id,
        public readonly BookTitle $title,
        public readonly string $author,
        public readonly ?string $description = null,
        public readonly ?DateTimeImmutable $readAt = null,
        public readonly ?BookRating $rating = null,
        public readonly ?DateTimeImmutable $createdAt = null,
        public readonly ?DateTimeImmutable $updatedAt = null
    ) {
    }

    // 感想更新用のメソッド
    public function withUpdatedDescription(string $description): self
    {
        return new self(
            id: $this->id,
            title: $this->title,
            author: $this->author,
            description: $description,
            readAt: $this->readAt,
            rating: $this->rating,
            createdAt: $this->createdAt,
            updatedAt: new DateTimeImmutable()
        );
    }

    // 評価更新用のメソッド
    public function withUpdatedRating(BookRating $rating): self
    {
        return new self(
            id: $this->id,
            title: $this->title,
            author: $this->author,
            description: $this->description,
            readAt: $this->readAt,
            rating: $rating,
            createdAt: $this->createdAt,
            updatedAt: new DateTimeImmutable()
        );
    }

    // ビジネスルールの例
    public function isRecentlyRead(): bool
    {
        if (!$this->readAt) {
            return false;
        }

        $thirtyDaysAgo = new DateTimeImmutable('-30 days');
        return $this->readAt > $thirtyDaysAgo;
    }

    public function isHighRated(): bool
    {
        return $this->rating && $this->rating->isHighRating();
    }
}
