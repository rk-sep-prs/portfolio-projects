<?php

declare(strict_types=1);

namespace App\Application\UseCases\Queries\ActivityLog;

use App\Domain\Entities\ActivityLog;

/**
 * 汎用アクティビティ履歴詳細取得クエリユースケースインターフェース
 * CQRS読み取り操作
 */
interface FindActivityLogByIdQueryUseCaseInterface
{
    /**
     * カテゴリとIDを指定して履歴を取得する
     *
     * @param string $category
     * @param string|int $id
     * @return ActivityLog|null
     */
    public function execute(string $category, $id): ?ActivityLog;
}
