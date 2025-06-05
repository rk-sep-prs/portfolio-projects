<?php

declare(strict_types=1);

namespace App\Application\Contracts;

/**
 * すべてのUseCaseの基底抽象クラス
 */
abstract class UseCase
{
    /**
     * ユースケースを実行する
     * 
     * @param mixed $input 入力データ
     * @return mixed 出力データ
     */
    abstract public function execute(mixed $input = null): mixed;
}
