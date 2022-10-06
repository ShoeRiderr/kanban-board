<?php

namespace App\Http\Controllers\Api;

use App\Events\TableEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanBoard\Task\AssignCollaboratorsRequest;
use App\Http\Requests\KanbanBoard\Task\ChangeOrderRequest;
use App\Http\Requests\KanbanBoard\Task\StoreRequest;
use App\Http\Requests\KanbanBoard\Task\UpdateRequest;
use App\Http\Resources\TableResource;
use App\Http\Resources\TaskResource;
use App\Models\KanbanBoard\Task;
use App\Services\FileService;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService, private FileService $fileService)
    {
    }

    public function index(): JsonResource
    {
        return TaskResource::collection(Task::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['order' => 9999]);

        return TaskResource::make(Task::create($data));
    }

    public function changeOrder(ChangeOrderRequest $request): JsonResponse
    {
        return response()->json(['status' => $this->taskService->changeOrder($request->get('tasks'))], JsonResponse::HTTP_OK);
    }

    public function assignCollaborators(Task $task, AssignCollaboratorsRequest $request)
    {
        try {
            $task->collaborators()->sync($request->get('collaborators'));

            TableEvent::dispatch(TableResource::make($task->column->table));
        } catch (Throwable $e) {
            logger($e->getMessage());
        }

        return response()->json(['status' => true]);
    }

    public function show(Task $task): JsonResource
    {
        return TaskResource::make($task);
    }

    public function update(UpdateRequest $request, Task $task): JsonResource
    {
        $task->update($request->validated());

        if ($request->has('tags')) {
            $task->tags()->sync($request->get('tags'));
        } else {
            $task->tags()->detach();
        }

        $files = $request->files->get('files');

        if ($files) {
            foreach ($files as $key => $file) {
                $task->files()->save($this->fileService->createFile($file, 'public', $key));
            }
        }

        TableEvent::dispatch(TableResource::make($task->column->table));

        return TaskResource::make($task);
    }

    public function archive(Task $task): JsonResponse
    {
        return response()->json($task->delete(), JsonResponse::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        return response()->json($task->forceDelete(), JsonResponse::HTTP_OK);
    }
}
