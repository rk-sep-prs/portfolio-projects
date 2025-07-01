<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog as BookLogEntity;  // エンティティに as を付ける
use App\Infrastructure\Persistence\Eloquent\BookLog as BookLogModel;  // モデルに明確なエイリアスを指定
use Illuminate\Support\Collection;

class EloquentBookLogRepository implements BookLogRepositoryInterface
{
    public function findAll(): Collection
    {
        $models = BookLogModel::all();
        
        return $models->map(fn($model) => $this->toEntity($model));
    }

    public function findById(string $id): ?BookLogEntity
    {
        $model = BookLogModel::find($id);
        
        return $model ? $this->toEntity($model) : null;
    }

    public function save(BookLogEntity $bookLog): void
    {
        BookLogModel::updateOrCreate(
            ['id' => $bookLog->id],
            [
                'title' => $bookLog->title,
                'author' => $bookLog->author,
                'description' => $bookLog->description,
                'read_at' => $bookLog->readAt,
                'rating' => $bookLog->rating, // 追加
            ]
        );
    }

    public function deleteById(string $id): void
    {
        $model = BookLogModel::find($id);
        if ($model) {
            $model->delete();
        }
    }

    private function toEntity(BookLogModel $model): BookLogEntity
    {
        return new BookLogEntity(
            id: $model->id,
            title: $model->title,
            author: $model->author,
            description: $model->description,
            readAt: $model->read_at ? new \DateTimeImmutable($model->read_at->format('Y-m-d H:i:s')) : null,
            rating: $model->rating, // 追加
            createdAt: $model->created_at ? new \DateTimeImmutable($model->created_at->format('Y-m-d H:i:s')) : null,
            updatedAt: $model->updated_at ? new \DateTimeImmutable($model->updated_at->format('Y-m-d H:i:s')) : null
        );
    }
}