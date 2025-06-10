<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface;
use App\Application\Queries\BookLog\ListBookLogsQuery;
use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得クエリInteractor
 * CQRS読み取り操作のビジネスロジック実装
 */
class ListBookLogsQueryInteractor extends UseCase implements ListBookLogsQueryUseCaseInterface
{
    public function __construct(
        private readonly ListBookLogsQuery $listBookLogsQuery
    ) {
    }

    /**
     * 読書記録一覧を取得するクエリユースケースを実行
     * 
     * @param mixed $input 入力データ（将来的に検索条件等を指定可能）
     * @return Collection 読書記録のコレクション
     */
    public function execute(mixed $input = null): Collection
    {
        // Queryを実行して読書記録一覧を取得
        return $this->listBookLogsQuery->execute($input);
    }
}
