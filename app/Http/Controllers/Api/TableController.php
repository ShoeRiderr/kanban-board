<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanBoard\Table\StoreRequest;
use App\Http\Requests\KanbanBoard\Table\UpdateRequest;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TableController extends Controller
{
    public function index(): JsonResource
    {
        return TableResource::collection(Table::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['order' => 9999]);

        return TableResource::make(Table::create($data));
    }

    public function show(Table $table): JsonResource
    {
        return TableResource::make($table);
    }

    public function update(UpdateRequest $request, Table $table): JsonResource
    {
        $table->update($request->validated());

        return TableResource::make($table);
    }

    public function archive(Table $table): JsonResponse
    {
        return response()->json($table->delete(), JsonResponse::HTTP_OK);
    }

    public function destroy(Table $table): JsonResponse
    {
        return response()->json($table->forceDelete(), JsonResponse::HTTP_OK);
    }
}
