<?php

declare(strict_types=1);

namespace App\Application\UseCases\Queries\BookLog;

use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;

/**
 * 読書記録詳細取得クエリユースケースインターフェース
 * CQRS読み取り操作
 */
interface FindBookLogByIdQueryUseCaseInterface
{
    /**
     * IDを指定して読書記録を取得する
     *
     * @param mixed $input 検索ID
     * @return BookLogResponseDTO|null 読書記録のDTOまたはnull
     */
    public function execute(mixed $input = null): ?BookLogResponseDTO;
}
