<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Infrastructure\Repositories\EloquentBookLogRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ★ ここでインターフェースと具象クラスを結びつける（バインドする）
        $this->app->bind(
            BookLogRepositoryInterface::class,
            EloquentBookLogRepository::class
        );

        // CQRS Query classes
        $this->app->bind(
            \App\Application\Queries\BookLog\ListBookLogsQuery::class,
            \App\Application\Queries\BookLog\ListBookLogsQuery::class
        );
        
        $this->app->bind(
            \App\Application\Queries\BookLog\FindBookLogByIdQuery::class,
            \App\Application\Queries\BookLog\FindBookLogByIdQuery::class
        );

        // CQRS Command classes
        $this->app->bind(
            \App\Application\Commands\BookLog\CreateBookLogCommand::class,
            \App\Application\Commands\BookLog\CreateBookLogCommand::class
        );
        
        $this->app->bind(
            \App\Application\Commands\BookLog\UpdateBookLogCommand::class,
            \App\Application\Commands\BookLog\UpdateBookLogCommand::class
        );

        // Interactor classes (UseCase implementations)
        $this->app->bind(
            \App\Application\Interactors\BookLog\ListBookLogsInteractor::class,
            \App\Application\Interactors\BookLog\ListBookLogsInteractor::class
        );
        
        $this->app->bind(
            \App\Application\Interactors\BookLog\FindBookLogByIdInteractor::class,
            \App\Application\Interactors\BookLog\FindBookLogByIdInteractor::class
        );
        
        $this->app->bind(
            \App\Application\Interactors\BookLog\CreateBookLogInteractor::class,
            \App\Application\Interactors\BookLog\CreateBookLogInteractor::class
        );
        
        $this->app->bind(
            \App\Application\Interactors\BookLog\UpdateBookLogInteractor::class,
            \App\Application\Interactors\BookLog\UpdateBookLogInteractor::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Presentation層のViewパスを追加
        $this->app['view']->addLocation(app_path('Presentation/Views'));
        
        // アセットパスの設定
        $this->app->bind('path.presentation.assets', function () {
            return app_path('Presentation/Assets');
        });
    }
}
