<?php

declare(strict_types=1);

namespace App\Application\DTOs\BookLogs\Output;

/**
 * BookLogレスポンスDTO（出力用）
 */
class BookLogResponseDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $author,
        public readonly ?string $description,
        public readonly ?string $readAt,
        public readonly ?int $rating,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }
}
