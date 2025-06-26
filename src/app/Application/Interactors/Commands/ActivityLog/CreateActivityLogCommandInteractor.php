<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\ActivityLog;

use App\Application\UseCases\Commands\ActivityLog\CreateActivityLogCommandUseCaseInterface;
use App\Domain\Repositories\ActivityLogRepositoryInterface;
use App\Domain\Entities\ActivityLog;

class CreateActivityLogCommandInteractor implements CreateActivityLogCommandUseCaseInterface
{
    public function __construct(
        private readonly ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function execute(array $input): ActivityLog
    {
        // 必須項目チェックはController/Requestで済ませる前提
        $data = [
            'category' => $input['category'],
            'title' => $input['title'],
            'author' => $input['author'] ?? null,
            'description' => $input['description'] ?? null,
            'activity_at' => $input['activity_at'] ?? null,
            'meta' => isset($input['meta']) ? json_encode($input['meta']) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        return $this->activityLogRepository->create($data);
    }
}
