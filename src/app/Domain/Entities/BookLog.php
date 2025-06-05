<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use DateTimeImmutable;

class BookLog
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $author,
        public readonly ?string $description = null,
        public readonly ?DateTimeImmutable $readAt = null,
        public readonly ?DateTimeImmutable $createdAt = null,
        public readonly ?DateTimeImmutable $updatedAt = null
    ) {
    }

    // 感想更新用のメソッド（必要に応じて）
    public function withUpdatedDescription(string $description): self
    {
        return new self(
            id: $this->id,
            title: $this->title,
            author: $this->author,
            description: $description,
            readAt: $this->readAt,
            createdAt: $this->createdAt,
            updatedAt: new DateTimeImmutable()
        );
    }
}