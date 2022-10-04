<?php

namespace App\Observers;

use App\Events\TableEvent;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Task;

class TaskObserver
{
    public function created(Task $task)
    {
        TableEvent::dispatch(TableResource::make($task->column->table));
    }

    public function updated(Task $task)
    {
        TableEvent::dispatch(TableResource::make($task->column->table));
    }

    public function deleted(Task $task)
    {
        TableEvent::dispatch(TableResource::make($task->column->table));
    }

    public function restored(Task $task)
    {
        TableEvent::dispatch(TableResource::make($task->column->table));
    }

    public function forceDeleted(Task $task)
    {
        TableEvent::dispatch(TableResource::make($task->column->table));
    }
}
