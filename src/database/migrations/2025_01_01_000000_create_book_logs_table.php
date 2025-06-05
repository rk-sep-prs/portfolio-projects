<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->datetime('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_logs');
    }
};