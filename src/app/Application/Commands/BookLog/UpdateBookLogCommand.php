<?php

declare(strict_types=1);

namespace App\Application\Commands\BookLog;

use App\Application\Contracts\Command;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use DateTimeImmutable;

/**
 * 読書記録更新コマンド
 */
class UpdateBookLogCommand extends Command
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録を更新する
     * 
     * @param mixed $data 更新データ配列（idとupdateDataを含む）
     * @return BookLog|null 更新された読書記録エンティティまたはnull
     */
    public function execute(mixed $data): ?BookLog
    {
        if (!is_array($data) || !isset($data['id'])) {
            throw new \InvalidArgumentException('Data must be an array with id');
        }

        $existingBookLog = $this->bookLogRepository->findById($data['id']);
        
        if (!$existingBookLog) {
            return null;
        }

        $updateData = $data['update_data'] ?? [];

        $updatedBookLog = new BookLog(
            id: $existingBookLog->id,
            title: $updateData['title'] ?? $existingBookLog->title,
            author: $updateData['author'] ?? $existingBookLog->author,
            description: $updateData['description'] ?? $existingBookLog->description,
            readAt: isset($updateData['read_at']) 
                ? ($updateData['read_at'] ? new DateTimeImmutable($updateData['read_at']) : null)
                : $existingBookLog->readAt,
            createdAt: $existingBookLog->createdAt,
            updatedAt: new DateTimeImmutable()
        );

        $this->bookLogRepository->save($updatedBookLog);

        return $updatedBookLog;
    }
}
