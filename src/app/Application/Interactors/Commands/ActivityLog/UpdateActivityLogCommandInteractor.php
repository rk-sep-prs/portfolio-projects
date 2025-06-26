<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\ActivityLog;

use App\Application\UseCases\Commands\ActivityLog\UpdateActivityLogCommandUseCaseInterface;
use App\Domain\Repositories\ActivityLogRepositoryInterface;
use App\Domain\Entities\ActivityLog;

class UpdateActivityLogCommandInteractor implements UpdateActivityLogCommandUseCaseInterface
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function execute(array $input): ?ActivityLog
    {
        if (!isset($input['id']) || !isset($input['category']) || !isset($input['update_data'])) {
            return null;
        }
        $id = $input['id'];
        $category = $input['category'];
        $updateData = $input['update_data'];
        $data = [
            'id' => $id,
            'category' => $category,
            'title' => $updateData['title'] ?? null,
            'author' => $updateData['author'] ?? null,
            'description' => $updateData['description'] ?? null,
            'activity_at' => $updateData['activity_at'] ?? null,
            'meta' => isset($updateData['meta']) ? json_encode($updateData['meta']) : null,
            'updated_at' => now(),
        ];
        return $this->activityLogRepository->update($data);
    }
}
