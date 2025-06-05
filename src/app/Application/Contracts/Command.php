<?php

declare(strict_types=1);

namespace App\Application\Contracts;

/**
 * すべてのCommandの基底抽象クラス
 * CQRSパターンにおける書き込み操作
 */
abstract class Command
{
    /**
     * コマンドを実行する
     * 
     * @param mixed $data 更新データ
     * @return mixed 実行結果
     */
    abstract public function execute(mixed $data): mixed;
}
