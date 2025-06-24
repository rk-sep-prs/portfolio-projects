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
