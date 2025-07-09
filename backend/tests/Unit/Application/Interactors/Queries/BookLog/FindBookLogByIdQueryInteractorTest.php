<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Queries\BookLog;

use App\Application\Interactors\Queries\BookLog\FindBookLogByIdQueryInteractor;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Domain\Entities\BookLog;
use PHPUnit\Framework\TestCase;
use Mockery;

class FindBookLogByIdQueryInteractorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_finds_book_log_by_id()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $bookId = 'test-id';
        $expectedBookLog = new BookLog(
            id: $bookId,
            title: 'Clean Architecture',
            author: 'Robert C. Martin',
            description: 'A great book about software architecture',
            readAt: new \DateTimeImmutable('2024-01-01'),
            createdAt: new \DateTimeImmutable('2024-01-01'),
            updatedAt: new \DateTimeImmutable('2024-01-01')
        );

        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($bookId)
            ->andReturn($expectedBookLog);

        $interactor = new FindBookLogByIdQueryInteractor($mockRepository);

        // Act
        $result = $interactor->execute($bookId);

        // Assert
        $this->assertEquals($expectedBookLog, $result);
    }

    public function test_execute_returns_null_when_not_found()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $bookId = 'non-existent-id';

        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($bookId)
            ->andReturn(null);

        $interactor = new FindBookLogByIdQueryInteractor($mockRepository);

        // Act
        $result = $interactor->execute($bookId);

        // Assert
        $this->assertNull($result);
    }
}
