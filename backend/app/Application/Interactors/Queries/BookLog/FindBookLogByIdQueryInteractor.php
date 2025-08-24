<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\BookLog;

use App\Application\UseCases\Queries\BookLog\FindBookLogByIdQueryUseCaseInterface;
use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;
use App\Domain\BookLog\Repositories\BookLogRepositoryInterface;

/**
 * 読書記録詳細取得クエリInteractor
 * CQRS読み取り操作のビジネスロジック実装
 */
class FindBookLogByIdQueryInteractor implements FindBookLogByIdQueryUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * IDを指定して読書記録を取得するクエリユースケースを実行
     *
     * @param mixed $input 検索ID
     * @return BookLogResponseDTO|null 読書記録のDTOまたはnull
     */
    public function execute(mixed $input = null): ?BookLogResponseDTO
    {
        $bookLog = $this->bookLogRepository->findById($input);

        if (!$bookLog) {
            return null;
        }

        // エンティティをDTOに変換して返す
        return BookLogResponseDTO::fromEntity($bookLog);
    }
}
