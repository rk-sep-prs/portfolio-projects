<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ActivityLogRepositoryInterface;
use App\Domain\Entities\ActivityLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function findByCategory(string $category): Collection
    {
        return collect(DB::table('activity_logs')->where('category', $category)->whereNull('deleted_at')->get())
            ->map(fn($row) => $this->toEntity($row));
    }

    public function findById(string $category, $id): ?ActivityLog
    {
        $row = DB::table('activity_logs')->where('category', $category)->where('id', $id)->whereNull('deleted_at')->first();
        return $row ? $this->toEntity($row) : null;
    }

    public function create(array $data): ActivityLog
    {
        $id = DB::table('activity_logs')->insertGetId($data);
        $row = DB::table('activity_logs')->where('id', $id)->first();
        return $this->toEntity($row);
    }

    public function update(array $data): ?ActivityLog
    {
        $id = $data['id'];
        unset($data['id']);
        DB::table('activity_logs')->where('id', $id)->update($data);
        $row = DB::table('activity_logs')->where('id', $id)->first();
        return $row ? $this->toEntity($row) : null;
    }

    public function delete(string $category, $id): void
    {
        DB::table('activity_logs')->where('category', $category)->where('id', $id)->update(['deleted_at' => now()]);
    }

    private function toEntity($row): ActivityLog
    {
        return new ActivityLog(
            $row->id,
            $row->category,
            $row->title,
            $row->author,
            $row->description,
            $row->activity_at,
            $row->meta ? json_decode($row->meta, true) : null,
            $row->created_at,
            $row->updated_at,
            $row->deleted_at
        );
    }
}
