<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Client::all()]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json(['data' => Client::create($request->validated())]);
    }

    public function show(Client $tag): JsonResponse
    {
        return response()->json(['data' => $tag]);
    }

    public function update(UpdateRequest $request, Client $tag): JsonResponse
    {
        return response()->json($tag->update($request->validated()));
    }

    public function destroy(Client $tag): JsonResponse
    {
        return response()->json($tag->delete());
    }
}
