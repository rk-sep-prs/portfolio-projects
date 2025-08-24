<?php

namespace App\Infrastructure\BookLog\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\BookLogFactory;

class BookLog extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return BookLogFactory::new();
    }

    protected $fillable = [
        "title",
        "author",
        "description",
        "read_at",
        "rating",
    ];

    protected $casts = [
        "read_at" => "datetime",
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "rating" => "integer",
    ];
}
