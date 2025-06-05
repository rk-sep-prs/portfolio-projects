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
        //
    }
}
