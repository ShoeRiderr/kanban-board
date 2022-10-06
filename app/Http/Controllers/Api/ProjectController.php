<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectController extends Controller
{
    public function index(): JsonResource
    {
        return ProjectResource::collection(Project::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        return ProjectResource::make(Project::create($request->validated()));
    }

    public function show(Project $project): JsonResource
    {
        return ProjectResource::make($project);
    }

    public function update(UpdateRequest $request, Project $project): JsonResource
    {
        $project->update($request->validated());

        return ProjectResource::make($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        return response()->json($project->delete());
    }
}
