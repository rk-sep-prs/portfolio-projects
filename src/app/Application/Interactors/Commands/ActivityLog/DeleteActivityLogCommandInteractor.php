<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\ActivityLog;

use App\Application\UseCases\Commands\ActivityLog\DeleteActivityLogCommandUseCaseInterface;
use App\Domain\Repositories\ActivityLogRepositoryInterface;

class DeleteActivityLogCommandInteractor implements DeleteActivityLogCommandUseCaseInterface
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function execute(string $category, $id): void
    {
        $this->activityLogRepository->delete($category, $id);
    }
}
