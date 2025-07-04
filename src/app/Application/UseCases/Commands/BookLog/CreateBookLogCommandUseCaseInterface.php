<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\BookLog;

use App\Domain\Entities\BookLog;

/**
 * 読書記録作成コマンドユースケースインターフェース
 * CQRS書き込み操作
 */
interface CreateBookLogCommandUseCaseInterface
{
    /**
     * 読書記録を作成する
     * 
     * @param mixed $input 作成データ配列
     * @return BookLog 作成された読書記録エンティティ
     */
    public function execute(mixed $input = null): BookLog;
}
