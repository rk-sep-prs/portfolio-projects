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
