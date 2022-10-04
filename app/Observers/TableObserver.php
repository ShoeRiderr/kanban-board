<?php

namespace App\Observers;

use App\Events\TableEvent;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Table;

class TableObserver
{
    public function created(Table $table)
    {
        TableEvent::dispatch(TableResource::make($table));
    }

    public function updated(Table $table)
    {
        TableEvent::dispatch(TableResource::make($table));
    }

    public function deleted(Table $table)
    {
        TableEvent::dispatch(TableResource::make($table));
    }

    public function restored(Table $table)
    {
        TableEvent::dispatch(TableResource::make($table));
    }

    public function forceDeleted(Table $table)
    {
        TableEvent::dispatch(TableResource::make($table));
    }
}
