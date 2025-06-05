<?php

declare(strict_types=1);

namespace App\Application\Interactors\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\Commands\BookLog\CreateBookLogCommand;
use App\Domain\Entities\BookLog;

/**
 * 読書記録作成Interactor
 */
class CreateBookLogInteractor extends UseCase
{
    public function __construct(
        private readonly CreateBookLogCommand $createBookLogCommand
    ) {
    }

    /**
     * 読書記録を作成するユースケースを実行
     * 
     * @param mixed $input 作成データ配列
     * @return BookLog 作成された読書記録エンティティ
     */
    public function execute(mixed $input = null): BookLog
    {
        return $this->createBookLogCommand->execute($input);
    }
}
