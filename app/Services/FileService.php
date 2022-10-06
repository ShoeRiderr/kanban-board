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

    public function update(File $file, array $data = []): bool
    {
        $result = $file->update($data);

        $this->checkFileOwner($file);

        return $result;
    }

    public function delete(File $file): bool
    {
        Storage::disk($file->storage)->delete($file->name);

        $result = $file->forceDelete();

        $this->checkFileOwner($file);

        return $result;
    }

    private function checkFileOwner(File $file): void
    {
        if (in_array($file->fileable_type, [Comment::class, Task::class])) {
            switch ($file->fileable_type) {
                case Comment::class:
                    TableEvent::dispatch(TableResource::make($file->fileable->task->column->table));
                    break;
                case Task::class:
                    TableEvent::dispatch(TableResource::make($file->fileable->column->table));
                    break;
            }
        }
    }
}
