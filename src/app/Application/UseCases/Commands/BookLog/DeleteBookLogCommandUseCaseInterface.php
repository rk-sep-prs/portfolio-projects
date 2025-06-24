<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\BookLog;

/**
 * 読書記録削除コマンドユースケースインターフェース
 * CQRS書き込み操作
 */
interface DeleteBookLogCommandUseCaseInterface
{
    /**
     * 読書記録を削除する
     * 
     * @param string $id 削除対象ID
     * @return void
     */
    public function execute(string $id): void;
}
