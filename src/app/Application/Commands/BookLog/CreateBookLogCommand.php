<?php

declare(strict_types=1);

namespace App\Application\Commands\BookLog;

use App\Application\Contracts\Command;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * 読書記録作成コマンド
 * CQRSパターンにおける書き込み操作
 */
class CreateBookLogCommand extends Command
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録を作成する
     * 
     * @param mixed $data 作成データ配列
     * @return BookLog 作成された読書記録エンティティ
     */
    public function execute(mixed $data): BookLog
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array');
        }

        $bookLog = new BookLog(
            id: Uuid::uuid4()->toString(),
            title: $data['title'] ?? '',
            author: $data['author'] ?? '',
            description: $data['description'] ?? null,
            readAt: isset($data['read_at']) ? new DateTimeImmutable($data['read_at']) : null,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        );

        $this->bookLogRepository->save($bookLog);

        return $bookLog;
    }
}
