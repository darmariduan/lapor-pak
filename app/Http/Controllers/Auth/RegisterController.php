<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Interfaces\ResidentRepositoryInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private ResidentRepositoryInterface $residentRepository;

    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auth.register');
    }

    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();
        $data['avatar'] = $data['avatar'] ? $data['avatar']->store('assets/avatars', 'public') : null;

        $this->residentRepository->createResident($data);

        return redirect()->route('auth.login')->with('success', 'Registration successful. Please login.');
    }
}
