<?php

declare(strict_types=1);

namespace App\Application\DTOs\BookLogs\Input;

/**
 * BookLog更新リクエストDTO（入力用）
 */
class BookLogUpdateRequestDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $author,
        public readonly ?string $description = null,
        public readonly ?string $readAt = null,
        public readonly ?int $rating = null,
    ) {
    }
}
