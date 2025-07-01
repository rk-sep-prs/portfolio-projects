<?php

declare(strict_types=1);

namespace App\Application\Interactors\Commands\BookLog;

use App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use App\Application\DTOs\BookLogUpdateDTO;
use App\Application\DTOs\BookLogs\Input\BookLogUpdateRequestDTO;
use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;
use Illuminate\Validation\ValidationException;

/**
 * 読書記録更新コマンドInteractor
 * CQRS書き込み操作のビジネスロジック実装
 */
class UpdateBookLogCommandInteractor implements UpdateBookLogCommandUseCaseInterface
{
    public function __construct(
        private readonly BookLogRepositoryInterface $bookLogRepository
    ) {
    }

    /**
     * 読書記録を更新するコマンドユースケースを実行
     * 
     * @param mixed $input 更新データ配列（idとupdate_dataを含む）
     * @return BookLog|null 更新された読書記録エンティティまたはnull
     */
    public function execute(mixed $input = null): ?BookLog
    {
        if (!$input || !isset($input['id']) || !isset($input['update_data'])) {
            return null;
        }

        $id = $input['id'];
        $updateData = $input['update_data'];
        
        // 既存の読書記録を取得
        $existingBookLog = $this->bookLogRepository->findById($id);
        if (!$existingBookLog) {
            return null;
        }

        // --- バリデーション ---
        // 必須項目チェック
        if (empty($updateData['title'])) {
            throw ValidationException::withMessages(['title' => 'タイトルは必須です']);
        }
        if (empty($updateData['author'])) {
            throw ValidationException::withMessages(['author' => '著者は必須です']);
        }
        // ratingも必須にしたい場合
        if (!isset($updateData['rating']) || $updateData['rating'] === null || $updateData['rating'] === '') {
            throw ValidationException::withMessages(['rating' => '評価は必須です']);
        }
        // 1〜10の範囲チェック
        if ($updateData['rating'] < 1 || $updateData['rating'] > 10) {
            throw ValidationException::withMessages(['rating' => '評価は1〜10で入力してください']);
        }

        // 入力DTOに詰め替え
        $rating = is_numeric($updateData['rating']) ? (int)$updateData['rating'] : null;
        $inputDto = new BookLogUpdateRequestDTO(
            title: $updateData['title'],
            author: $updateData['author'],
            description: $updateData['description'] ?? null,
            readAt: $updateData['read_at'] ?? null,
            rating: $rating
        );

        // 新しいエンティティを作成（不変オブジェクト）
        $updatedBookLog = new BookLog(
            id: $existingBookLog->id,
            title: $inputDto->title,
            author: $inputDto->author,
            description: $inputDto->description ?? $existingBookLog->description,
            readAt: isset($inputDto->readAt) && $inputDto->readAt ? new \DateTimeImmutable($inputDto->readAt) : $existingBookLog->readAt,
            rating: $inputDto->rating,
            createdAt: $existingBookLog->createdAt,
            updatedAt: new \DateTimeImmutable()
        );

        // リポジトリに保存
        $this->bookLogRepository->save($updatedBookLog);

        // 出力DTOに詰め替えて返す（必要に応じて）
        // return new BookLogResponseDTO(...)

        return $updatedBookLog; // 既存互換のため一旦エンティティ返却
    }
}
