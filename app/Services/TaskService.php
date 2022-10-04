<?php

namespace App\Services;

use App\Models\KanbanBoard\Task;

class TaskService
{
    public function changeOrder(array $tasks): bool
    {
        try {
            foreach ($tasks as $task) {
                Task::find($task['id'])->update([
                    'order' => $task['order'],
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
