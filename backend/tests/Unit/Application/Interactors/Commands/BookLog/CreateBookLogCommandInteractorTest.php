<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Interactors\Commands\BookLog;

use App\Application\Interactors\Commands\BookLog\CreateBookLogCommandInteractor;
use App\Domain\Repositories\BookLogRepositoryInterface;
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

    public function test_execute_creates_book_log()
    {
        // Arrange
        $mockRepository = Mockery::mock(BookLogRepositoryInterface::class);
        $inputData = [
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'description' => 'A great book about software architecture',
            'read_at' => '2024-01-01'
        ];

        // リポジトリのsaveメソッドが呼ばれることを期待
        $mockRepository->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($bookLog) use ($inputData) {
                return $bookLog instanceof BookLog &&
                       $bookLog->title === $inputData['title'] &&
                       $bookLog->author === $inputData['author'] &&
                       $bookLog->description === $inputData['description'] &&
                       $bookLog->readAt instanceof \DateTimeImmutable;
            }));

        $interactor = new CreateBookLogCommandInteractor($mockRepository);

        // Act
        $result = $interactor->execute($inputData);

        // Assert
        $this->assertInstanceOf(BookLog::class, $result);
        $this->assertEquals($inputData['title'], $result->title);
        $this->assertEquals($inputData['author'], $result->author);
        $this->assertEquals($inputData['description'], $result->description);
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->readAt);
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->createdAt);
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->updatedAt);
    }
}
