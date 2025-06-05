<?php

declare(strict_types=1);

namespace App\Application\Queries\BookLog;

use App\Application\Contracts\Query;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;

/**
 * 読書記録単体取得クエリ
 */
class FindBookLogByIdQuery extends Query
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * IDを指定して読書記録を取得する
     * 
     * @param mixed $criteria 検索ID
     * @return BookLog|null 読書記録エンティティまたはnull
     */
    public function execute(mixed $criteria = null): ?BookLog
    {
        if (!is_string($criteria)) {
            return null;
        }

        return $this->bookLogRepository->findById($criteria);
    }
}
