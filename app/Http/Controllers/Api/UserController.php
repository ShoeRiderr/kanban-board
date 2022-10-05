<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(): JsonResource
    {
        return UserResource::collection(User::all());
    }

    public function show(User $user): JsonResource
    {
        return UserResource::make($user);
    }

    public function store(StoreRequest $request)
    {
        return response()->json($this->userService->create($request->validated()));
    }

    public function update(User $user, UpdateRequest $request)
    {
        $this->userService->update($user, $request->validated());

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        return response()->json($user->delete(), JsonResponse::HTTP_OK);
    }
}
