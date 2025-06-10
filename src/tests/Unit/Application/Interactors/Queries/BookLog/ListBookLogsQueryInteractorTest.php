<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Queries\BookLog;

use App\Application\Interactors\Queries\BookLog\ListBookLogsQueryInteractor;
use App\Application\Queries\BookLog\ListBookLogsQuery;
use App\Domain\Entities\BookLog;
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

    public function test_execute_delegates_to_query()
    {
        // Arrange
        $mockQuery = Mockery::mock(ListBookLogsQuery::class);
        $expectedBookLogs = new Collection([
            new BookLog(
                id: '1',
                title: 'Clean Architecture',
                author: 'Robert C. Martin',
                description: 'A great book about software architecture',
                readAt: new \DateTimeImmutable('2024-01-01'),
                createdAt: new \DateTimeImmutable('2024-01-01'),
                updatedAt: new \DateTimeImmutable('2024-01-01')
            )
        ]);

        $mockQuery->shouldReceive('execute')
            ->once()
            ->with(null)
            ->andReturn($expectedBookLogs);

        $interactor = new ListBookLogsQueryInteractor($mockQuery);

        // Act
        $result = $interactor->execute();

        // Assert
        $this->assertEquals($expectedBookLogs, $result);
    }

    public function test_execute_passes_input_to_query()
    {
        // Arrange
        $mockQuery = Mockery::mock(ListBookLogsQuery::class);
        $inputCriteria = ['status' => 'completed'];
        $expectedBookLogs = new Collection();

        $mockQuery->shouldReceive('execute')
            ->once()
            ->with($inputCriteria)
            ->andReturn($expectedBookLogs);

        $interactor = new ListBookLogsQueryInteractor($mockQuery);

        // Act
        $result = $interactor->execute($inputCriteria);

        // Assert
        $this->assertEquals($expectedBookLogs, $result);
    }
}
