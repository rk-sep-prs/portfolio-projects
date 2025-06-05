<?php

declare(strict_types=1);

namespace App\Application\Interactors\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\Queries\BookLog\ListBookLogsQuery;
use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得Interactor
 * UseCaseを継承し、具体的なビジネスロジックを実装
 */
class ListBookLogsInteractor extends UseCase
{
    public function __construct(
        private readonly ListBookLogsQuery $listBookLogsQuery
    ) {
    }

    /**
     * 読書記録一覧を取得するユースケースを実行
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
