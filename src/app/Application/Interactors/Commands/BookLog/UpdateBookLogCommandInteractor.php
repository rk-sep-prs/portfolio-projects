<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;

/**
 * 読書記録更新コマンドInteractor
 * CQRS書き込み操作のビジネスロジック実装
 */
class UpdateBookLogCommandInteractor implements UpdateBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録を更新するコマンドユースケースを実行
     * 
     * @param mixed $input 更新データ配列（idとupdate_dataを含む）
     * @return BookLog|null 更新された読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog
    {
        if (!$input || !isset($input['id']) || !isset($input['update_data'])) {
            return null;
        }

        $id = $input['id'];
        $updateData = $input['update_data'];
        
        // 既存の読書記録を取得
        $existingBookLog = $this->bookLogRepository->findById($id);
        if (!$existingBookLog) {
            return null;
        }

        // 新しいエンティティを作成（不変オブジェクト）
        $updatedBookLog = new BookLog(
            id: $existingBookLog->id,
            title: $updateData['title'] ?? $existingBookLog->title,
            author: $updateData['author'] ?? $existingBookLog->author,
            description: $updateData['description'] ?? $existingBookLog->description,
            readAt: isset($updateData['read_at']) 
                ? ($updateData['read_at'] ? new \DateTimeImmutable($updateData['read_at']) : null)
                : $existingBookLog->readAt,
            createdAt: $existingBookLog->createdAt,
            updatedAt: new \DateTimeImmutable()
        );

        // リポジトリに保存
        $this->bookLogRepository->save($updatedBookLog);

        return $updatedBookLog;
    }
}
