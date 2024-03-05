<?php

namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {

    }

    public function register(RegisterRequest $request)
    {
        $result = $this->service->register($request->validated());

        return response()->json($result);
    }
}
