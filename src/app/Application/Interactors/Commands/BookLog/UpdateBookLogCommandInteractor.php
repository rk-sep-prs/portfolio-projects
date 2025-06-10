<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\Contracts\UseCase;
use App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface;
use App\Application\Commands\BookLog\UpdateBookLogCommand;
use App\Domain\Entities\BookLog;

/**
 * 読書記録更新コマンドInteractor
 * CQRS書き込み操作のビジネスロジック実装
 */
class UpdateBookLogCommandInteractor extends UseCase implements UpdateBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly UpdateBookLogCommand $updateBookLogCommand
    ) {
    }

    /**
     * 読書記録を更新するコマンドユースケースを実行
     * 
     * @param mixed $input 更新データ配列（idとupdate_dataを含む）
     * @return BookLog|null 更新された読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog
    {
        return $this->updateBookLogCommand->execute($input);
    }
}
