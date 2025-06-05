<?php

declare(strict_types=1);

namespace App\Application\Interactors\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\Queries\BookLog\FindBookLogByIdQuery;
use App\Domain\Entities\BookLog;

/**
 * 読書記録詳細取得Interactor
 */
class FindBookLogByIdInteractor extends UseCase
{
    public function __construct(
        private readonly FindBookLogByIdQuery $findBookLogByIdQuery
    ) {
    }

    /**
     * IDを指定して読書記録を取得するユースケースを実行
     * 
     * @param mixed $input 検索ID
     * @return BookLog|null 読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog
    {
        return $this->findBookLogByIdQuery->execute($input);
    }
}
