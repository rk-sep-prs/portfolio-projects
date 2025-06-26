<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\ActivityLog;

use App\Domain\Entities\ActivityLog;

interface CreateActivityLogCommandUseCaseInterface
{
    /**
     * @param array $input
     * @return ActivityLog
     */
    public function execute(array $input): ActivityLog;
}
