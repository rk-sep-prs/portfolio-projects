<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface;
use App\Application\Commands\BookLog\CreateBookLogCommand;
use App\Domain\Entities\BookLog;

/**
 * 読書記録作成コマンドInteractor
 * CQRS書き込み操作のビジネスロジック実装
 */
class CreateBookLogCommandInteractor extends UseCase implements CreateBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly CreateBookLogCommand $createBookLogCommand
    ) {
    }

    /**
     * 読書記録を作成するコマンドユースケースを実行
     * 
     * @param mixed $input 作成データ配列
     * @return BookLog 作成された読書記録エンティティ
     */
    public function execute(mixed $input = null): BookLog
    {
        return $this->createBookLogCommand->execute($input);
    }
}
