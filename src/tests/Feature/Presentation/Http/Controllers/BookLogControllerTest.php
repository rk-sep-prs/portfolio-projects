<?php

declare(strict_types=1);

namespace Tests\Feature\Presentation\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Infrastructure\Persistence\Eloquent\BookLog;

class BookLogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_book_logs()
    {
        // Arrange
        BookLog::factory()->create([
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'A great book about software architecture',
            'read_at' => now()->subDays(10),
        ]);

        BookLog::factory()->create([
            'title' => 'Domain-Driven Design',
            'author' => 'Eric Evans',
            'description' => 'The definitive guide to DDD',
            'read_at' => null,
        ]);

        // Act
        $response = $this->get('/booklogs');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('booklogs.index');
        $response->assertViewHas('bookLogs');
        $response->assertSee('Clean Architecture');
        $response->assertSee('Robert C. Martin');
        $response->assertSee('Domain-Driven Design');
        $response->assertSee('Eric Evans');
    }

    public function test_index_displays_empty_state_when_no_books()
    {
        // Act
        $response = $this->get('/booklogs');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('booklogs.index');
        $response->assertSee('まだ読書ログはありません');
    }
}
