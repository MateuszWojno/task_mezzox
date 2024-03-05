<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {

    }

    public function login(LoginRequest $request)
    {
        $result = $this->service->login($request->validated());

        return response()->json(...$result);
    }


    public function register(RegisterRequest $request)
    {
        $result = $this->service->register($request->validated());

        return response()->json($result);
    }
}
