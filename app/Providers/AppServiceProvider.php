<?php

namespace App\Providers;

use App\Models\KanbanBoard\Column;
use App\Models\KanbanBoard\Comment;
use App\Models\KanbanBoard\Table;
use App\Models\KanbanBoard\Task;
use App\Observers\ColumnObserver;
use App\Observers\CommentObserver;
use App\Observers\TableObserver;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Table::observe(TableObserver::class);
        Column::observe(ColumnObserver::class);
        Task::observe(TaskObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
