<?php

declare(strict_types=1);

namespace App\Application\UseCases\BookLog;

use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得ユースケースインターフェース
 */
interface ListBookLogsUseCaseInterface
{
    /**
     * 読書記録の一覧を取得する
     * 
     * @param mixed $input 入力データ（将来的に検索条件等を指定可能）
     * @return Collection 読書記録のコレクション
     */
    public function execute(mixed $input = null): Collection;
}
