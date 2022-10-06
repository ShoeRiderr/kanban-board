<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanBoard\Column\ChangeOrderRequest;
use App\Http\Requests\KanbanBoard\Column\StoreRequest;
use App\Http\Requests\KanbanBoard\Column\UpdateRequest;
use App\Http\Resources\ColumnResource;
use App\Models\KanbanBoard\Column;
use App\Services\ColumnService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ColumnController extends Controller
{
    public function __construct(private ColumnService $columnService)
    {
    }

    public function index(): JsonResource
    {
        return ColumnResource::collection(Column::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['order' => 9999]);

        return ColumnResource::make(Column::create($data));
    }

    public function changeOrder(ChangeOrderRequest $request): JsonResponse
    {
        return response()->json(['status' => $this->columnService->changeOrder($request->get('columns'))], JsonResponse::HTTP_OK);
    }

    public function show(Column $column): JsonResource
    {
        return ColumnResource::make($column);
    }

    public function update(UpdateRequest $request, Column $column): JsonResource
    {
        return ColumnResource::make($column->update($request->validated()));
    }

    public function archive(Column $column): JsonResponse
    {
        return response()->json($column->delete(), JsonResponse::HTTP_OK);
    }

    public function destroy(Column $column): JsonResponse
    {
        return response()->json($column->forceDelete(), JsonResponse::HTTP_OK);
    }
}
