<?php

namespace App\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookLog extends Model
{
    use HasUuids;

    protected $fillable = [
        "title",
        "author", 
        "description",
        "read_at",
    ];

    protected $casts = [
        "read_at" => "datetime",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];
}
