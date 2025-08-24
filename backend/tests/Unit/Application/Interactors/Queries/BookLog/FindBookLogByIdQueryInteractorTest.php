<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Queries\BookLog;

use App\Application\Interactors\Queries\BookLog\FindBookLogByIdQueryInteractor;
use App\Application\DTOs\BookLogs\Output\BookLogResponseDTO;
use App\Domain\BookLog\Repositories\BookLogRepositoryInterface;
use App\Domain\BookLog\Entities\BookLog;
use App\Domain\BookLog\ValueObjects\BookTitle;
use App\Domain\BookLog\ValueObjects\BookRating;
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
        $bookLogEntity = new BookLog(
            id: $bookId,
            title: new BookTitle('Clean Architecture'),
            author: 'Robert C. Martin',
            description: 'A great book about software architecture',
            readAt: new \DateTimeImmutable('2024-01-01'),
            rating: new BookRating(8),
            createdAt: new \DateTimeImmutable('2024-01-01'),
            updatedAt: new \DateTimeImmutable('2024-01-01')
        );

        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($bookId)
            ->andReturn($bookLogEntity);

        $interactor = new FindBookLogByIdQueryInteractor($mockRepository);

        // Act
        $result = $interactor->execute($bookId);

        // Assert
        $this->assertInstanceOf(BookLogResponseDTO::class, $result);
        $this->assertEquals($bookId, $result->id);
        $this->assertEquals('Clean Architecture', $result->title);  // 文字列として直接アクセス
        $this->assertEquals('Robert C. Martin', $result->author);
        $this->assertEquals(8, $result->rating);                   // 整数として直接アクセス
        $this->assertTrue($result->isHighRated());                 // ビジネスロジックのテスト
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
