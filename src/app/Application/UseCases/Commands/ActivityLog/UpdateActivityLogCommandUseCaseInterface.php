<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\ActivityLog;

use App\Domain\Entities\ActivityLog;

interface UpdateActivityLogCommandUseCaseInterface
{
    /**
     * @param array $input
     * @return ActivityLog|null
     */
    public function execute(array $input): ?ActivityLog;
}
