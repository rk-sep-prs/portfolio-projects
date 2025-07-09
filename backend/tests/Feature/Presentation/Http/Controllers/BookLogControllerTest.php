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
    
    public function test_edit_displays_edit_form()
    {
        // Arrange
        $bookLog = BookLog::factory()->create([
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'A great book about software architecture',
            'read_at' => now()->subDays(10),
        ]);

        // Act
        $response = $this->get("/booklogs/{$bookLog->id}/edit");

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('booklogs.edit');
        $response->assertViewHas('bookLog');
        $response->assertSee('Clean Architecture');
        $response->assertSee('Robert C. Martin');
        $response->assertSee('A great book about software architecture');
    }

    public function test_edit_returns_404_for_nonexistent_book()
    {
        // Act
        $response = $this->get('/booklogs/nonexistent-id/edit');

        // Assert
        $response->assertStatus(404);
    }

    public function test_update_modifies_book_log()
    {
        // Arrange
        $bookLog = BookLog::factory()->create([
            'title' => 'Original Title',
            'author' => 'Original Author',
            'description' => 'Original description',
            'read_at' => now()->subDays(10),
            'rating' => 5,
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'description' => 'Updated description',
            'read_at' => now()->subDays(5)->format('Y-m-d'),
            'rating' => 8,
        ];

        // Act
        $response = $this->put("/booklogs/{$bookLog->id}", $updateData);

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('/booklogs');
        $response->assertSessionHas('success', '読書記録を更新しました。');

        // Verify database changes
        $updatedBookLog = BookLog::find($bookLog->id);
        $this->assertEquals('Updated Title', $updatedBookLog->title);
        $this->assertEquals('Updated Author', $updatedBookLog->author);
        $this->assertEquals('Updated description', $updatedBookLog->description);
    }

    public function test_update_validates_required_fields()
    {
        // Arrange
        $bookLog = BookLog::factory()->create([
            'rating' => 5,
        ]);

        // Act
        $response = $this->put("/booklogs/{$bookLog->id}", [
            'title' => '',
            'author' => '',
            'rating' => '', // ratingも空で送信
        ]);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'author']);
    }

    public function test_update_returns_404_for_nonexistent_book()
    {
        // Act
        $response = $this->put('/booklogs/nonexistent-id', [
            'title' => 'Some Title',
            'author' => 'Some Author',
            'rating' => 5,
        ]);

        // Assert
        $response->assertStatus(404);
    }

    public function test_destroy_soft_deletes_book_log()
    {
        // Arrange
        $bookLog = BookLog::factory()->create([
            'title' => 'Delete Me',
            'author' => 'Author',
            'description' => 'To be deleted',
            'read_at' => now()->subDays(1),
        ]);

        // Act
        $response = $this->delete("/booklogs/{$bookLog->id}");

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('/booklogs');
        $response->assertSessionHas('success', '読書記録を削除しました。');

        // 一覧に表示されない
        $this->get('/booklogs')->assertDontSee('Delete Me');

        // DB上はdeleted_atがセットされている
        $this->assertSoftDeleted('book_logs', [
            'id' => $bookLog->id,
            'title' => 'Delete Me',
        ]);
    }

    public function test_destroy_nonexistent_book_log_is_safe()
    {
        // Act
        $response = $this->delete('/booklogs/nonexistent-id');

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect('/booklogs');
        $response->assertSessionHas('success', '読書記録を削除しました。');
    }
}
