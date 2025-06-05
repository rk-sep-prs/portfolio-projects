<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Commands\BookLog;

use App\Application\Commands\BookLog\CreateBookLogCommand;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use PHPUnit\Framework\TestCase;
use Mockery;

class CreateBookLogCommandTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_creates_book_log_successfully()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $inputData = [
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'A great book about software architecture',
            'read_at' => '2024-01-01'
        ];

        $mockRepository->shouldReceive('save')
            ->once()
            ->andReturnUsing(function (BookLog $bookLog) use ($inputData) {
                $this->assertEquals($inputData['title'], $bookLog->title);
                $this->assertEquals($inputData['author'], $bookLog->author);
                $this->assertEquals($inputData['description'], $bookLog->description);
                return null;
            });

        $command = new CreateBookLogCommand($mockRepository);

        // Act
        $result = $command->execute($inputData);

        // Assert
        $this->assertInstanceOf(BookLog::class, $result);
        $this->assertEquals($inputData['title'], $result->title);
        $this->assertEquals($inputData['author'], $result->author);
        $this->assertEquals($inputData['description'], $result->description);
    }

    public function test_execute_throws_exception_for_invalid_data()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $command = new CreateBookLogCommand($mockRepository);

        // Act & Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Data must be an array');
        
        $command->execute('invalid data');
    }
}
