<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\BookLog;

use App\Domain\Entities\BookLog;

/**
 * 読書記録更新コマンドユースケースインターフェース
 * CQRS書き込み操作
 */
interface UpdateBookLogCommandUseCaseInterface
{
    /**
     * 読書記録を更新する
     * 
     * @param mixed $input 更新データ配列（idとupdate_dataを含む）
     * @return BookLog|null 更新された読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog;
}
