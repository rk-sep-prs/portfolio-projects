<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // BookLogの初期データを追加
        $this->call(BookLogSeeder::class);
    }
}
