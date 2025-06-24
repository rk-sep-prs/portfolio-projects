<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Commands\BookLog;

use App\Application\Interactors\Commands\BookLog\DeleteBookLogCommandInteractor;
use App\Domain\Repositories\BookLogRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class DeleteBookLogCommandInteractorTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_deletes_book_log_by_id()
    {
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $mockRepository->shouldReceive('deleteById')
            ->once()
            ->with('test-id');

        $interactor = new DeleteBookLogCommandInteractor($mockRepository);
        $interactor->execute('test-id');
    }

    public function test_execute_does_not_throw_on_nonexistent_id()
    {
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $mockRepository->shouldReceive('deleteById')
            ->once()
            ->with('nonexistent-id');

        $interactor = new DeleteBookLogCommandInteractor($mockRepository);
        $interactor->execute('nonexistent-id');
        $this->assertTrue(true); // 例外が出なければOK
    }
}
