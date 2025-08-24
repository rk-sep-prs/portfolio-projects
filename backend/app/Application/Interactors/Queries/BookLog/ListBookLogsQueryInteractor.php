<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\BookLog;

use App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface;
use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;
use App\Domain\BookLog\Repositories\BookLogRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得クエリInteractor
 * CQRS読み取り操作のビジネスロジック実装
 */
class ListBookLogsQueryInteractor implements ListBookLogsQueryUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録一覧を取得するクエリユースケースを実行
     *
     * @param mixed $input 入力データ（将来的に検索条件等を指定可能）
     * @return Collection<int, BookLogResponseDTO> 読書記録のDTOコレクション
     */
    public function execute(mixed $input = null): Collection
    {
        // リポジトリから読書記録一覧を取得
        $bookLogs = $this->bookLogRepository->findAll();

        // エンティティをDTOに変換して返す
        return $bookLogs->map(fn($bookLog) => BookLogResponseDTO::fromEntity($bookLog));
    }
}
