<?php

namespace App\Http\Controllers;

use App\Http\Request\LoginRequest;
use App\Http\Request\LogoutRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json($request->user()->createToken());
        }

        return response()->json(['error' => 'Unauthorized']);
    }
    public function logout(LogoutRequest $request): void
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

}
