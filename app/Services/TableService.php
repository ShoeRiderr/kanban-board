<?php

namespace App\Services;

use App\Models\KanbanBoard\Table;
use Illuminate\Support\Arr;

class TableService
{
    public function create(array $data = []): Table
    {
        $users = Arr::pull($data, 'users');

        $table = Table::create($data);

        $table->users()->attach($users);

        return $table;
    }

    public function update(Table $table, array $data = []): Table
    {
        $users = Arr::pull($data, 'users');

        $table->update($data);

        $table->users()->sync($users);

        return $table;
    }
}
