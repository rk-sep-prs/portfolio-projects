<?php

declare(strict_types=1);

namespace App\Application\UseCases\Commands\ActivityLog;

interface DeleteActivityLogCommandUseCaseInterface
{
    /**
     * @param string $category
     * @param string|int $id
     * @return void
     */
    public function execute(string $category, $id): void;
}
