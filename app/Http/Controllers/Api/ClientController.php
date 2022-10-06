<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller
{
    public function index(): JsonResource
    {
        return ClientResource::collection(Client::all());
    }

    public function store(StoreRequest $request): JsonResource
    {
        return ClientResource::make(Client::create($request->validated()));
    }

    public function show(Client $client): JsonResource
    {
        return ClientResource::make($client);
    }

    public function update(UpdateRequest $request, Client $client): JsonResource
    {
        $client->update($request->validated());

        return ClientResource::make($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        return response()->json($client->delete());
    }
}
