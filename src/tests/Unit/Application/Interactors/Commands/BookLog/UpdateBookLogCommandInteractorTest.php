<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Commands\BookLog;

use App\Application\Interactors\Commands\BookLog\UpdateBookLogCommandInteractor;
use App\Application\Commands\BookLog\UpdateBookLogCommand;
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

    public function test_execute_delegates_to_command()
    {
        // Arrange
        $mockCommand = Mockery::mock(UpdateBookLogCommand::class);
        $updateData = [
            'id' => 'test-id',
            'update_data' => [
                'title' => 'Updated Clean Architecture',
                'author' => 'Robert C. Martin',
                'description' => 'Updated description',
                'read_at' => '2024-01-02'
            ]
        ];

        $expectedBookLog = new BookLog(
            id: $updateData['id'],
            title: $updateData['update_data']['title'],
            author: $updateData['update_data']['author'],
            description: $updateData['update_data']['description'],
            readAt: new \DateTimeImmutable($updateData['update_data']['read_at']),
            createdAt: new \DateTimeImmutable('2024-01-01'),
            updatedAt: new \DateTimeImmutable('2024-01-02')
        );

        $mockCommand->shouldReceive('execute')
            ->once()
            ->with($updateData)
            ->andReturn($expectedBookLog);

        $interactor = new UpdateBookLogCommandInteractor($mockCommand);

        // Act
        $result = $interactor->execute($updateData);

        // Assert
        $this->assertEquals($expectedBookLog, $result);
        $this->assertEquals($updateData['update_data']['title'], $result->title);
    }

    public function test_execute_returns_null_when_not_found()
    {
        // Arrange
        $mockCommand = Mockery::mock(UpdateBookLogCommand::class);
        $updateData = [
            'id' => 'non-existent-id',
            'update_data' => [
                'title' => 'Updated Title'
            ]
        ];

        $mockCommand->shouldReceive('execute')
            ->once()
            ->with($updateData)
            ->andReturn(null);

        $interactor = new UpdateBookLogCommandInteractor($mockCommand);

        // Act
        $result = $interactor->execute($updateData);

        // Assert
        $this->assertNull($result);
    }
}
