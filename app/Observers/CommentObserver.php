<?php

namespace App\Observers;

use App\Events\TableEvent;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        TableEvent::dispatch(TableResource::make($comment->task->column->table));
    }

    public function updated(Comment $comment)
    {
        TableEvent::dispatch(TableResource::make($comment->task->column->table));
    }

    public function deleted(Comment $comment)
    {
        TableEvent::dispatch(TableResource::make($comment->task->column->table));
    }

    public function restored(Comment $comment)
    {
        TableEvent::dispatch(TableResource::make($comment->task->column->table));
    }

    public function forceDeleted(Comment $comment)
    {
        TableEvent::dispatch(TableResource::make($comment->task->column->table));
    }
}
