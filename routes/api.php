<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('clients', ClientController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tags', TagController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('files', FileController::class, [
    'only' => ['update', 'destroy'],
]);

Route::prefix('kanban-board')->group(function () {
    Route::apiResource('tables', TableController::class);

    Route::apiResource('columns', ColumnController::class);

    Route::apiResource('tasks', TaskController::class, [
        'except' => ['update'],
    ]);

    Route::apiResource('comments', CommentController::class, [
        'except' => ['update'],
    ]);

    Route::prefix('tables')->group(function () {
        Route::delete('archive/{table}', [TableController::class, 'archive']);
    });

    Route::prefix('columns')->group(function () {
        Route::post('change-order', [ColumnController::class, 'changeOrder']);
        Route::delete('archive/{column}', [ColumnController::class, 'archive']);
    });

    Route::prefix('tasks')->group(function () {
        Route::post('assign-collaborators/{task}', [TaskController::class, 'assignCollaborators']);
        Route::post('change-order', [TaskController::class, 'changeOrder']);
        Route::delete('archive/{task}', [TaskController::class, 'archive']);
        Route::post('update/{task}', [TaskController::class, 'update']);
    });

    Route::prefix('comments')->group(function () {
        Route::post('update/{comment}', [CommentController::class, 'update']);
        Route::delete('archive/{comment}', [CommentController::class, 'archive']);
    });
});
