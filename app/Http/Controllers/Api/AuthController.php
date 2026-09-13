<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'password' => Hash::make($request->validated('password')),
            'is_online' => true,
        ];

        if ($request->hasFile('avatar')) {
            $userData['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($userData);

        $token = $user->createToken($request->header('User-Agent', 'auth_token'))->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'meta' => [
                'message' => 'User registered successfully'
            ]
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            return response()->json([
                'message' => 'Die Zugangsdaten sind inkorrekt.',
                'errors' => [
                    'email' => ['Die Zugangsdaten sind inkorrekt.']
                ]
            ], 422);
        }

        $user->update(['is_online' => true]);

        $deviceName = $request->validated('device_name') ?? $request->header('User-Agent', 'auth_token');
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'meta' => [
                'message' => 'Login successful'
            ]
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user(),
            'meta' => []
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->update(['is_online' => false, 'last_seen_at' => now()]);

        return response()->json([
            'data' => [
                'user' => $request->user(),
                'message' => 'Logged out successfully'
            ]
        ]);
    }
}
