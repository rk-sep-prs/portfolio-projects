<?php

declare(strict_types=1);

namespace App\Domain\BookLog\Repositories;

use App\Domain\BookLog\Entities\BookLog;
use Illuminate\Support\Collection;

interface BookLogRepositoryInterface
{
    /**
     * 全ての読書記録を取得します。
     *
     * @return Collection<int, BookLog> BookLogエンティティのコレクション
     */
    public function findAll(): Collection;

    /**
     * IDを指定して読書記録を1件取得します。
     * 見つからない場合は null を返します。
     *
     * @param string $id 検索する読書記録のID (UUIDなど)
     * @return BookLog|null 見つかったBookLogエンティティ、または null
     */
    public function findById(string $id): ?BookLog;

    /**
     * 読書記録を永続化（新規作成または更新）します。
     *
     * @param BookLog $bookLog 保存するBookLogエンティティ
     * @return void
     */
    public function save(BookLog $bookLog): void;

    /**
     * IDを指定して論理削除します。
     *
     * @param string $id 削除する読書記録のID
     * @return void
     */
    public function deleteById(string $id): void;
}
