<?php

declare(strict_types=1);

namespace App\Application\UseCases\BookLog;

use App\Domain\Entities\BookLog;

/**
 * 読書記録詳細取得ユースケースインターフェース
 */
interface FindBookLogByIdUseCaseInterface
{
    /**
     * IDを指定して読書記録を取得する
     * 
     * @param mixed $input 検索ID
     * @return BookLog|null 読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog;
}
