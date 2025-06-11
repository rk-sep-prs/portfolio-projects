<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;

/**
 * 読書記録作成コマンドInteractor
 * CQRS書き込み操作のビジネスロジック実装
 */
class CreateBookLogCommandInteractor implements CreateBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録を作成するコマンドユースケースを実行
     * 
     * @param mixed $input 作成データ配列
     * @return BookLog 作成された読書記録エンティティ
     */
    public function execute(mixed $input = null): BookLog
    {
        // UUIDの生成（Laravel標準のStr::uuid()を使用）
        $id = \Illuminate\Support\Str::uuid()->toString();
        
        // エンティティを作成
        $bookLog = new BookLog(
            id: $id,
            title: $input['title'],
            author: $input['author'],
            description: $input['description'] ?? null,
            readAt: isset($input['read_at']) && $input['read_at'] 
                ? new \DateTimeImmutable($input['read_at']) 
                : null,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable()
        );

        // リポジトリに保存
        $this->bookLogRepository->save($bookLog);

        return $bookLog;
    }
}
