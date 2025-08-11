<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials)
    {
        // Logic for user login
        return Auth::attempt($credentials);
    }

    public function logout()
    {
        // Logic for user logout
        return Auth::logout();
    }

    public function register(array $data)
    {
        // Logic for user registration
        return Auth::create($data);
    }
}
