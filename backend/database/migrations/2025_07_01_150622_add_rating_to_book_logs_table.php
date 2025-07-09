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
        Schema::table('book_logs', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable()->after('read_at'); // 10段階評価用
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
