<?php

namespace App\Http\Controllers;

use App\Models\KanbanBoard\Table;
use Illuminate\View\View;

class TableController extends Controller
{
    public function index(): View
    {
        return view('modules.kanban-board.index');
    }

    public function show(Table $table): View
    {
        return view('modules.kanban-board.show', [
            'table' => $table,
        ]);
    }
}
