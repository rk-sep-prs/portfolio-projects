<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\BookLogRepositoryInterface;
use App\Infrastructure\Repositories\EloquentBookLogRepository;
use App\Domain\Repositories\ActivityLogRepositoryInterface;
use App\Infrastructure\Repositories\EloquentActivityLogRepository;
use App\Application\UseCases\Queries\ActivityLog\ListActivityLogsQueryUseCaseInterface;
use App\Application\Interactors\Queries\ActivityLog\ListActivityLogsQueryInteractor;
use App\Application\UseCases\Queries\ActivityLog\FindActivityLogByIdQueryUseCaseInterface;
use App\Application\Interactors\Queries\ActivityLog\FindActivityLogByIdQueryInteractor;
use App\Application\UseCases\Commands\ActivityLog\CreateActivityLogCommandUseCaseInterface;
use App\Application\Interactors\Commands\ActivityLog\CreateActivityLogCommandInteractor;
use App\Application\UseCases\Commands\ActivityLog\UpdateActivityLogCommandUseCaseInterface;
use App\Application\Interactors\Commands\ActivityLog\UpdateActivityLogCommandInteractor;
use App\Application\UseCases\Commands\ActivityLog\DeleteActivityLogCommandUseCaseInterface;
use App\Application\Interactors\Commands\ActivityLog\DeleteActivityLogCommandInteractor;

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

        $this->app->bind(
            ActivityLogRepositoryInterface::class,
            EloquentActivityLogRepository::class
        );

        // CQRS UseCase Interface bindings - コントローラーはこれらのインターフェースに依存
        // Query UseCases (読み取り操作)
        $this->app->bind(
            \App\Application\UseCases\Queries\BookLog\ListBookLogsQueryUseCaseInterface::class,
            \App\Application\Interactors\Queries\BookLog\ListBookLogsQueryInteractor::class
        );
        
        $this->app->bind(
            \App\Application\UseCases\Queries\BookLog\FindBookLogByIdQueryUseCaseInterface::class,
            \App\Application\Interactors\Queries\BookLog\FindBookLogByIdQueryInteractor::class
        );

        $this->app->bind(
            ListActivityLogsQueryUseCaseInterface::class,
            ListActivityLogsQueryInteractor::class
        );
        
        $this->app->bind(
            FindActivityLogByIdQueryUseCaseInterface::class,
            FindActivityLogByIdQueryInteractor::class
        );

        // Command UseCases (書き込み操作)
        $this->app->bind(
            \App\Application\UseCases\Commands\BookLog\CreateBookLogCommandUseCaseInterface::class,
            \App\Application\Interactors\Commands\BookLog\CreateBookLogCommandInteractor::class
        );
        
        $this->app->bind(
            \App\Application\UseCases\Commands\BookLog\UpdateBookLogCommandUseCaseInterface::class,
            \App\Application\Interactors\Commands\BookLog\UpdateBookLogCommandInteractor::class
        );

        $this->app->bind(
            \App\Application\UseCases\Commands\BookLog\DeleteBookLogCommandUseCaseInterface::class,
            \App\Application\Interactors\Commands\BookLog\DeleteBookLogCommandInteractor::class
        );

        $this->app->bind(
            CreateActivityLogCommandUseCaseInterface::class,
            CreateActivityLogCommandInteractor::class
        );
        
        $this->app->bind(
            UpdateActivityLogCommandUseCaseInterface::class,
            UpdateActivityLogCommandInteractor::class
        );

        $this->app->bind(
            DeleteActivityLogCommandUseCaseInterface::class,
            DeleteActivityLogCommandInteractor::class
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
