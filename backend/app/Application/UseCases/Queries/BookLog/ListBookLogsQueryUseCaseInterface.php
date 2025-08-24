<?php

declare(strict_types=1);

namespace App\Application\UseCases\Queries\BookLog;

use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;
use Illuminate\Support\Collection;

/**
 * 読書記録一覧取得クエリユースケースインターフェース
 * CQRS読み取り操作
 */
interface ListBookLogsQueryUseCaseInterface
{
    /**
     * 読書記録の一覧を取得する
     *
     * @param mixed $input 入力データ（将来的に検索条件等を指定可能）
     * @return Collection<int, BookLogResponseDTO> 読書記録のDTOコレクション
     */
    public function execute(mixed $input = null): Collection;
}
