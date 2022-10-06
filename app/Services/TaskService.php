<?php

namespace App\Services;

use App\Models\KanbanBoard\Task;

class TaskService
{
    public function changeOrder(array $tasks): bool
    {
        try {
            foreach ($tasks as $task) {
                Task::find($task['id'])->update($task);
            }

            return true;
        } catch (\Throwable $e) {
            logger($e->getMessage());
            return false;
        }
    }
}
