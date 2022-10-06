<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::prefix('clients')->group(function () {
        Route::get('', [ClientController::class, 'index'])->name('clients.index');
        Route::get('create', [ClientController::class, 'create'])->name('clients.create');
        Route::get('{table}', [ClientController::class, 'edit'])->name('clients.edit');
    });
    Route::prefix('kanban-board')->group(function () {
        Route::get('', [TableController::class, 'index'])->name('kanban-board.index');
        Route::get('table/{table}', [TableController::class, 'show'])->name('kanban-board.show');
    });
    Route::prefix('projects')->group(function () {
        Route::get('', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('create', [ProjectController::class, 'create'])->name('projects.create');
        Route::get('{table}', [ProjectController::class, 'edit'])->name('projects.edit');
    });
});
