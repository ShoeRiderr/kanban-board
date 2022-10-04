<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Project::all()]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json(['data' => Project::create($request->validated())]);
    }

    public function show(Project $tag): JsonResponse
    {
        return response()->json(['data' => $tag]);
    }

    public function update(UpdateRequest $request, Project $tag): JsonResponse
    {
        return response()->json($tag->update($request->validated()));
    }

    public function destroy(Project $tag): JsonResponse
    {
        return response()->json($tag->delete());
    }
}
