<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\ActivityLog;

use App\Application\UseCases\Queries\ActivityLog\FindActivityLogByIdQueryUseCaseInterface;
use App\Domain\Repositories\ActivityLogRepositoryInterface;
use App\Domain\Entities\ActivityLog;

class FindActivityLogByIdQueryInteractor implements FindActivityLogByIdQueryUseCaseInterface
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function execute(string $category, $id): ?ActivityLog
    {
        return $this->activityLogRepository->findById($category, $id);
    }
}
