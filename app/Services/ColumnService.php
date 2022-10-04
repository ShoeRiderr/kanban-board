<?php

namespace App\Services;

use App\Models\KanbanBoard\Column;

class ColumnService
{
    public function changeOrder(array $columns): bool
    {
        try {
            foreach ($columns as $column) {
                Column::find($column['id'])->update([
                    'order' => $column['order'],
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
