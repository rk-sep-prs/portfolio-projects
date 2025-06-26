<?php

declare(strict_types=1);

namespace App\Application\Interactors\Queries\ActivityLog;

use App\Application\UseCases\Queries\ActivityLog\ListActivityLogsQueryUseCaseInterface;
use App\Domain\Repositories\ActivityLogRepositoryInterface;
use Illuminate\Support\Collection;

class ListActivityLogsQueryInteractor implements ListActivityLogsQueryUseCaseInterface
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function execute(string $category): Collection
    {
        return $this->activityLogRepository->findByCategory($category);
    }
}
