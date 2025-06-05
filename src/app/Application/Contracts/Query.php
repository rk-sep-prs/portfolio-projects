<?php

declare(strict_types=1);

namespace App\Application\Contracts;

/**
 * すべてのQueryの基底抽象クラス
 * CQRSパターンにおける読み取り専用操作
 */
abstract class Query
{
    /**
     * クエリを実行する
     * 
     * @param mixed $criteria 検索条件
     * @return mixed 検索結果
     */
    abstract public function execute(mixed $criteria = null): mixed;
}
