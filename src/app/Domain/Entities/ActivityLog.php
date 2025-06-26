<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class ActivityLog
{
    public int $id;
    public string $category;
    public string $title;
    public ?string $author;
    public ?string $description;
    public ?string $activity_at;
    public ?array $meta;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(
        int $id,
        string $category,
        string $title,
        ?string $author = null,
        ?string $description = null,
        ?string $activity_at = null,
        ?array $meta = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?string $deleted_at = null
    ) {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->activity_at = $activity_at;
        $this->meta = $meta;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->deleted_at = $deleted_at;
    }
}
