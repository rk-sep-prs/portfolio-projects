<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Infrastructure\Persistence\Eloquent\BookLog;

class BookLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookLog::create([
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'ソフトウェア設計とアーキテクチャについての本。クリーンアーキテクチャの原則を学べる素晴らしい一冊。',
            'read_at' => now()->subDays(30),
        ]);

        BookLog::create([
            'title' => 'ドメイン駆動設計',
            'author' => 'Eric Evans',
            'description' => 'DDD（ドメイン駆動設計）の名著。複雑なソフトウェアの設計に必要な概念が詰まっている。',
            'read_at' => now()->subDays(20),
        ]);

        BookLog::create([
            'title' => 'Laravel実践開発',
            'author' => '竹澤有貴',
            'description' => 'LaravelでのWebアプリケーション開発の実践的な内容。MVCからClean Architectureまで学べる。',
            'read_at' => now()->subDays(10),
        ]);

        BookLog::create([
            'title' => 'リファクタリング',
            'author' => 'Martin Fowler',
            'description' => 'コードの品質を向上させるためのリファクタリング技法について。現在読書中。',
            'read_at' => null, // まだ読み終わっていない
        ]);

        BookLog::create([
            'title' => 'オブジェクト指向設計実践ガイド',
            'author' => 'Sandi Metz',
            'description' => 'Rubyを使ったオブジェクト指向設計の実践的な解説書。設計原則を具体例とともに学べる。',
            'read_at' => now()->subDays(5),
        ]);
    }
}
