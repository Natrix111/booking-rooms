<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('storage/avatars'), $avatarName);
            $avatarPath = 'avatars/' . $avatarName;
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => new RegisterResource($user),
            'user_token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Неверный email или пароль'], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        return new LoginResource($user);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

}
