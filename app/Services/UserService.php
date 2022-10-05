<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function changePassword(User $user, $password): bool
    {
        return $user->update(['password' => Hash::make($password)]);
    }

    public function create(array $data): User
    {
        Arr::set($data, 'password', Hash::make(Arr::get($data, 'password', '')));

        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        if (Arr::has($data, 'password')) {
            Arr::set($data, 'password', Hash::make(Arr::get($data, 'password')));
        }

        return $user->update($data);
    }
}
