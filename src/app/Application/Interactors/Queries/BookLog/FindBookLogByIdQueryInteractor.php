<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\UseCases\Queries\BookLog\FindBookLogByIdQueryUseCaseInterface;
use App\Application\Queries\BookLog\FindBookLogByIdQuery;
use App\Domain\Entities\BookLog;

/**
 * 読書記録詳細取得クエリInteractor
 * CQRS読み取り操作のビジネスロジック実装
 */
class FindBookLogByIdQueryInteractor extends UseCase implements FindBookLogByIdQueryUseCaseInterface
{
    public function __construct(
        private readonly FindBookLogByIdQuery $findBookLogByIdQuery
    ) {
    }

    /**
     * IDを指定して読書記録を取得するクエリユースケースを実行
     * 
     * @param mixed $input 検索ID
     * @return BookLog|null 読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog
    {
        return $this->findBookLogByIdQuery->execute($input);
    }
}
