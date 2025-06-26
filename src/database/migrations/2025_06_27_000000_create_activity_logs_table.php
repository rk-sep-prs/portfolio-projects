<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // カテゴリ名（例: book, movie, anime, study など）
            $table->string('title');
            $table->string('author')->nullable(); // 本・映画・アニメ等の制作者名
            $table->text('description')->nullable();
            $table->date('activity_at')->nullable(); // 活動日（読了日・鑑賞日など）
            $table->json('meta')->nullable(); // カテゴリごとの追加情報を柔軟に格納
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
