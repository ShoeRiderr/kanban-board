<?php

namespace App\Observers;

use App\Events\TableEvent;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Column;

class ColumnObserver
{
    public function created(Column $column)
    {
        TableEvent::dispatch(TableResource::make($column->table));
    }

    public function updated(Column $column)
    {
        TableEvent::dispatch(TableResource::make($column->table));
    }

    public function deleted(Column $column)
    {
        TableEvent::dispatch(TableResource::make($column->table));
    }

    public function restored(Column $column)
    {
        TableEvent::dispatch(TableResource::make($column->table));
    }

    public function forceDeleted(Column $column)
    {
        TableEvent::dispatch(TableResource::make($column->table));
    }
}
