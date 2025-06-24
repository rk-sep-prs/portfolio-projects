<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\UseCases\Commands\BookLog\DeleteBookLogCommandUseCaseInterface;
use App\Domain\Repositories\BookLogRepositoryInterface;

class DeleteBookLogCommandInteractor implements DeleteBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    public function execute(string $id): void
    {
        $this->bookLogRepository->deleteById($id);
    }
}
