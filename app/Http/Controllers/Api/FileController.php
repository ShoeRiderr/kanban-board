<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    public function update(FileRequest $request, File $file): JsonResponse
    {
        return response()->json(['status' => $this->fileService->update($file, $request->validated())]);
    }

    public function destroy(File $file): JsonResponse
    {
        return response()->json(['status' => $this->fileService->delete($file)]);
    }
}
