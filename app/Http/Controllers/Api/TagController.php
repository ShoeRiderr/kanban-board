<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TagController extends Controller
{
    public function index(): JsonResource
    {
        return TagResource::collection(Tag::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        return TagResource::make(Tag::create($request->validated()));
    }

    public function show(Tag $tag): JsonResource
    {
        return TagResource::make($tag);
    }

    public function update(UpdateRequest $request, Tag $tag): JsonResource
    {
        $tag->update($request->validated());

        return TagResource::make($tag);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        return response()->json($tag->delete());
    }
}
