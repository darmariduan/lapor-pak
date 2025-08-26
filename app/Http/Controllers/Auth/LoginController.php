<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoginRequest;
use App\Interfaces\AuthRepositoryInterface;

class LoginController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function index()
    {
        return view('pages.auth.login');
    }
    public function store(StoreLoginRequest $request)
    {
        $credentials = $request->validated();
        if ($this->authRepository->login($credentials)) {
            $user = auth()->user();
            if ($user && $user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user && $user->hasRole('resident')) {
                return redirect()->route('home');
            }
        }

        return redirect()->route('auth.login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        $this->authRepository->logout();
        return redirect()->route('auth.login');
    }
}
