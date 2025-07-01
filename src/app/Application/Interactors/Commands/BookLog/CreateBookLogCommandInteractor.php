<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use App\Application\DTOs\BookLogs\Input\BookLogUpdateRequestDTO;
use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;

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
        
        // 入力DTOに詰め替え
        $rating = isset($input['rating']) && is_numeric($input['rating']) ? (int)$input['rating'] : null;
        $inputDto = new BookLogUpdateRequestDTO(
            title: $input['title'],
            author: $input['author'],
            description: $input['description'] ?? null,
            readAt: $input['read_at'] ?? null,
            rating: $rating
        );

        // エンティティを作成
        $bookLog = new BookLog(
            id: $id,
            title: $inputDto->title,
            author: $inputDto->author,
            description: $inputDto->description,
            readAt: isset($inputDto->readAt) && $inputDto->readAt
                ? new \DateTimeImmutable($inputDto->readAt)
                : null,
            rating: $inputDto->rating,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable()
        );

        // リポジトリに保存
        $this->bookLogRepository->save($bookLog);

        // 出力DTOに詰め替えて返す（必要に応じて）
        // return new BookLogResponseDTO(...)

        return $bookLog; // 既存互換のため一旦エンティティ返却
    }
}
