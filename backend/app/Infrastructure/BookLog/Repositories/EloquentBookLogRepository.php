<?php

declare(strict_types=1);

namespace App\Infrastructure\BookLog\Repositories;

use App\Domain\BookLog\Repositories\BookLogRepositoryInterface;
use App\Domain\BookLog\Entities\BookLog as BookLogEntity;
use App\Domain\BookLog\ValueObjects\BookTitle;
use App\Domain\BookLog\ValueObjects\BookRating;
use App\Infrastructure\BookLog\Persistence\Eloquent\BookLog as BookLogModel;
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
                'title' => $bookLog->title->value(),
                'author' => $bookLog->author,
                'description' => $bookLog->description,
                'read_at' => $bookLog->readAt,
                'rating' => $bookLog->rating?->value(),
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
            title: new BookTitle($model->title),
            author: $model->author,
            description: $model->description,
            readAt: $model->read_at ? new \DateTimeImmutable($model->read_at->format('Y-m-d H:i:s')) : null,
            rating: $model->rating ? new BookRating($model->rating) : null,
            createdAt: $model->created_at ? new \DateTimeImmutable($model->created_at->format('Y-m-d H:i:s')) : null,
            updatedAt: $model->updated_at ? new \DateTimeImmutable($model->updated_at->format('Y-m-d H:i:s')) : null
        );
    }
}
