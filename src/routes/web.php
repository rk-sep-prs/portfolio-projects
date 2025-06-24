<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\BookLogController; // 作成したControllerをuse

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ↓↓↓ この行を追加 ↓↓↓
Route::get('/booklogs', [BookLogController::class, 'index'])->name('booklogs.index');
Route::get('/booklogs/{id}/edit', [BookLogController::class, 'edit'])->name('booklogs.edit');
Route::put('/booklogs/{id}', [BookLogController::class, 'update'])->name('booklogs.update');
Route::delete('/booklogs/{id}', [BookLogController::class, 'destroy'])->name('booklogs.destroy');