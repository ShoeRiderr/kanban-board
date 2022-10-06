<?php

namespace App\Http\Controllers\Api;

use App\Events\TableEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\KanbanBoard\Comment\StoreRequest;
use App\Http\Requests\KanbanBoard\Comment\UpdateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\TableResource;
use App\Models\KanbanBoard\Comment;
use App\Services\CommentService;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CommentController extends Controller
{
    public function __construct(
        private CommentService $commentService,
        private FileService $fileService
    ) {
    }

    public function index(): JsonResource
    {
        return CommentResource::collection(Comment::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        $files = $request->files->get('files');
        $comment = Comment::create($request->validated());

        if ($files) {
            foreach ($files as $key => $file) {
                $comment->files()->save($this->fileService->createFile($file, 'public', $key));
            }
        }

        TableEvent::dispatch(TableResource::make($comment->task->column->table));

        return CommentResource::make($comment);
    }

    public function show(Comment $comment): JsonResource
    {
        return CommentResource::make($comment);
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResource
    {
        $files = $request->files->get('files');

        $this->commentService->update($comment, $request->validated());

        if ($files) {
            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $comment->files()->save($this->fileService->createFile($file, 'public', $key));
                }
            }
        }

        TableEvent::dispatch(TableResource::make($comment->task->column->table));

        return CommentResource::make($comment);
    }

    public function archive(Comment $comment): JsonResponse
    {
        return response()->json($comment->delete(), JsonResponse::HTTP_OK);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        return response()->json($comment->forceDelete(), JsonResponse::HTTP_OK);
    }
}
