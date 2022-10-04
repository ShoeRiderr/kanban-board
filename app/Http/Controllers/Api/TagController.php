<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Tag::all()]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json(['data' => Tag::create($request->validated())]);
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json(['data' => $tag]);
    }

    public function update(UpdateRequest $request, Tag $tag): JsonResponse
    {
        return response()->json($tag->update($request->validated()));
    }

    public function destroy(Tag $tag): JsonResponse
    {
        return response()->json($tag->delete());
    }
}
