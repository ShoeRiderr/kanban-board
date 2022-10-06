<?php

namespace App\Services;

use App\Events\TableEvent;
use App\Http\Resources\TableResource;
use App\Models\File;
use App\Models\KanbanBoard\Comment;
use App\Models\KanbanBoard\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Exception;
use Throwable;

class FileService
{
    const MAX_SIDE_LENGTH = 40;

    public function createFile($file, string $storage, int $uniqueKey = 0): File
    {
        try {
            $currentTimestamp = Carbon::now()->format('Y_m_d_His');
            $fileName = $currentTimestamp . $uniqueKey . '.' . $file->getClientOriginalExtension();

            $file->move(config('filesystems.disks.' . $storage . '.root'), $fileName);

            return new File([
                'storage' => $storage,
                'name' => $fileName,
                'origin_name' => $file->getClientOriginalName(),
            ]);
        } catch (Throwable $e) {
            logger($e->getMessage());
            throw new Exception('Something went wrong during saving the image.');
        }
    }

    public function update(int $id, array $data = [])
    {
        $file = $this->model->find($id);
        $result = $file->update($data);

        if ($file->fileable_type === Comment::class) {
            $comment = Comment::find($file->fileable_id);

            TableEvent::dispatch(TableResource::make($comment->task->column->table));
        }

        return $result;
    }

    public function delete(int $id)
    {
        $file = $this->model->find($id);

        Storage::disk($file->storage)->delete($file->name);

        $result = $file->forceDelete();

        if ($file->fileable_type === Comment::class) {
            $comment = Comment::find($file->fileable_id);

            TableEvent::dispatch(TableResource::make($comment->task->column->table));
        }

        if ($file->fileable_type === Task::class) {
            $task = Task::find($file->fileable_id);

            TableEvent::dispatch(TableResource::make($task->column->table));
        }

        return $result;
    }
}
