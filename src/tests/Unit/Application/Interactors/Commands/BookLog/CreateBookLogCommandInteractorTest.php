<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Commands\BookLog;

use App\Application\Interactors\Commands\BookLog\CreateBookLogCommandInteractor;
use App\Application\Commands\BookLog\CreateBookLogCommand;
use App\Domain\Entities\BookLog;
use PHPUnit\Framework\TestCase;
use Mockery;

class CreateBookLogCommandInteractorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_delegates_to_command()
    {
        // Arrange
        $mockCommand = Mockery::mock(CreateBookLogCommand::class);
        $inputData = [
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'A great book about software architecture',
            'read_at' => '2024-01-01'
        ];

        $expectedBookLog = new BookLog(
            id: 'test-id',
            title: $inputData['title'],
            author: $inputData['author'],
            description: $inputData['description'],
            readAt: new \DateTimeImmutable($inputData['read_at']),
            createdAt: new \DateTimeImmutable('2024-01-01'),
            updatedAt: new \DateTimeImmutable('2024-01-01')
        );

        $mockCommand->shouldReceive('execute')
            ->once()
            ->with($inputData)
            ->andReturn($expectedBookLog);

        $interactor = new CreateBookLogCommandInteractor($mockCommand);

        // Act
        $result = $interactor->execute($inputData);

        // Assert
        $this->assertEquals($expectedBookLog, $result);
        $this->assertEquals($inputData['title'], $result->title);
        $this->assertEquals($inputData['author'], $result->author);
        $this->assertEquals($inputData['description'], $result->description);
    }
}
