<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Queries\BookLog;

use App\Application\Interactors\Queries\BookLog\ListBookLogsQueryInteractor;
use App\Domain\BookLog\Repositories\BookLogRepositoryInterface;
use App\Domain\BookLog\Entities\BookLog;
use App\Domain\BookLog\ValueObjects\BookTitle;
use App\Domain\BookLog\ValueObjects\BookRating;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Mockery;

class ListBookLogsQueryInteractorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_returns_all_book_logs()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $expectedBookLogs = new Collection([
            new BookLog(
                id: '1',
                title: new BookTitle('Clean Architecture'),
                author: 'Robert C. Martin',
                description: 'A great book about software architecture',
                readAt: new \DateTimeImmutable('2024-01-01'),
                rating: new BookRating(8),
                createdAt: new \DateTimeImmutable('2024-01-01'),
                updatedAt: new \DateTimeImmutable('2024-01-01')
            )
        ]);

        $mockRepository->shouldReceive('findAll')
            ->once()
            ->andReturn($expectedBookLogs);

        $interactor = new ListBookLogsQueryInteractor($mockRepository);

        // Act
        $result = $interactor->execute();

        // Assert
        $this->assertEquals($expectedBookLogs, $result);
    }

    public function test_execute_returns_empty_collection_when_no_books()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $expectedBookLogs = new Collection();

        $mockRepository->shouldReceive('findAll')
            ->once()
            ->andReturn($expectedBookLogs);

        $interactor = new ListBookLogsQueryInteractor($mockRepository);

        // Act
        $result = $interactor->execute();

        // Assert
        $this->assertEquals($expectedBookLogs, $result);
        $this->assertTrue($result->isEmpty());
    }
}
