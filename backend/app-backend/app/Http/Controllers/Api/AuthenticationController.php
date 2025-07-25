<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AuthenticationService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Auth;

class AuthenticationController extends Controller
{
    public function __construct(
        protected AuthenticationService $authenticationService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authenticationService->create($data);
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(LoginRequest $request): JsonResponse 
    {
        $data = $request->validated();
        $credentials = $request->only('email', 'password');

        // Check if the user exists and the password is correct
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

}