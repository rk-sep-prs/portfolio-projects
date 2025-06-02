<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('checkdb', function () {
    $this->comment('--- Checking DB Configuration ---');

    // 環境変数を直接確認してみる
    $this->comment('getenv(DB_CONNECTION): ' . (getenv('DB_CONNECTION') ?: '<<Not Set>>'));
    $this->comment('$_ENV[DB_CONNECTION]: ' . ($_ENV['DB_CONNECTION'] ?? '<<Not Set>>'));
    $this->comment('$_SERVER[DB_CONNECTION]: ' . ($_SERVER['DB_CONNECTION'] ?? '<<Not Set>>'));

    // env() ヘルパーの結果も再確認
    $this->comment('env(DB_CONNECTION): ' . (env('DB_CONNECTION') ?: '<<Blank>>'));

    // Laravel Config の結果
    $this->comment('config(database.default): ' . Config::get('database.default'));
    $this->comment('DB::getDefaultConnection(): ' . DB::getDefaultConnection());

    $this->comment("\n--- Attempting Connection ---");
    try {
        DB::connection()->getPdo();
        $this->info('SUCCESS: DB connection successful using default connection! Driver: ' . DB::connection()->getDriverName());
    } catch (\Exception $e) {
        $this->error('FAILED: DB connection failed!');
        $this->error('Error Message: ' . $e->getMessage());
    }
    $this->comment('-----------------------------');
})->purpose('Check effective database connection settings');