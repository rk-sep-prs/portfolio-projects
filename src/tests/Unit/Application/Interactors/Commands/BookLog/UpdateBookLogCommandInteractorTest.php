<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Commands\BookLog;

use App\Application\Interactors\Commands\BookLog\UpdateBookLogCommandInteractor;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use PHPUnit\Framework\TestCase;
use Mockery;

class UpdateBookLogCommandInteractorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_updates_book_log()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $updateData = [
            'id' => 'test-id',
            'update_data' => [
                'title' => 'Updated Clean Architecture',
                'author' => 'Robert C. Martin',
                'description' => 'Updated description',
                'read_at' => '2024-01-02'
            ]
        ];

        $existingBookLog = new BookLog(
            id: 'test-id',
            title: 'Original Title',
            author: 'Original Author',
            description: 'Original description',
            readAt: new \DateTimeImmutable('2024-01-01'),
            createdAt: new \DateTimeImmutable('2024-01-01'),
            updatedAt: new \DateTimeImmutable('2024-01-01')
        );

        // 既存のBookLogを取得
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with('test-id')
            ->andReturn($existingBookLog);

        // 更新されたBookLogを保存
        $mockRepository->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($bookLog) use ($updateData) {
                return $bookLog instanceof BookLog &&
                       $bookLog->id === $updateData['id'] &&
                       $bookLog->title === $updateData['update_data']['title'] &&
                       $bookLog->author === $updateData['update_data']['author'] &&
                       $bookLog->description === $updateData['update_data']['description'];
            }));

        $interactor = new UpdateBookLogCommandInteractor($mockRepository);

        // Act
        $result = $interactor->execute($updateData);

        // Assert
        $this->assertInstanceOf(BookLog::class, $result);
        $this->assertEquals($updateData['update_data']['title'], $result->title);
        $this->assertEquals($updateData['update_data']['author'], $result->author);
        $this->assertEquals($updateData['update_data']['description'], $result->description);
    }

    public function test_execute_returns_null_when_not_found()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $updateData = [
            'id' => 'non-existent-id',
            'update_data' => [
                'title' => 'Updated Title'
            ]
        ];

        $mockRepository->shouldReceive('findById')
            ->once()
            ->with('non-existent-id')
            ->andReturn(null);

        $interactor = new UpdateBookLogCommandInteractor($mockRepository);

        // Act
        $result = $interactor->execute($updateData);

        // Assert
        $this->assertNull($result);
    }
}
