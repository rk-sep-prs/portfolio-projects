<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;
use App\Domain\Entities\ActivityLog;

interface ActivityLogRepositoryInterface
{
    /**
     * カテゴリごとに履歴一覧を取得
     * @param string $category
     * @return Collection
     */
    public function findByCategory(string $category): Collection;

    /**
     * カテゴリとIDで1件取得
     * @param string $category
     * @param string|int $id
     * @return ActivityLog|null
     */
    public function findById(string $category, $id): ?ActivityLog;

    // 作成・更新・削除も定義
    public function create(array $data): ActivityLog;
    public function update(array $data): ?ActivityLog;
    public function delete(string $category, $id): void;
}
