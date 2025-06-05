<?php

declare(strict_types=1);

namespace App\Application\Queries\BookLog;

use App\Application\Contracts\Query;
use App\Domain\Repositories\BookLogRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得クエリ
 * CQRSパターンにおける読み取り専用操作
 */
class ListBookLogsQuery extends Query
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録の一覧を取得する
     * 
     * @param mixed $criteria 検索条件（将来的に並び順、フィルタ等を指定可能）
     * @return Collection 読書記録のコレクション
     */
    public function execute(mixed $criteria = null): Collection
    {
        // 将来的には $criteria を使って並び順やフィルタリングを実装
        return $this->bookLogRepository->findAll();
    }
}
