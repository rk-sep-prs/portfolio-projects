<?php

declare(strict_types=1);

namespace App\Application\UseCases\Queries\ActivityLog;

use Illuminate\Support\Collection;

/**
 * 汎用アクティビティ履歴一覧取得クエリユースケースインターフェース
 * CQRS読み取り操作
 */
interface ListActivityLogsQueryUseCaseInterface
{
    /**
     * カテゴリを指定して履歴の一覧を取得する
     *
     * @param string $category
     * @return Collection
     */
    public function execute(string $category): Collection;
}
