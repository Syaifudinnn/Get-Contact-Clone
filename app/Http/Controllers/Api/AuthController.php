<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //login
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();

            // Delete existing tokens
            $user->tokens()->delete();

            // Get all permissions and filter valid abilities
            $abilities = $user->getAllPermissions()->pluck('name')->toArray();
            $validAbilities = array_filter($abilities, function ($ability) {
                return is_string($ability) && strpos($ability, ':') !== false;
            });

            // Create token with valid abilities
            $token = $user->createToken('token-name', $validAbilities)->plainTextToken;

            return new LoginResource([
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }
    }

    //register
    // public function register(RegisterRequest $request)
    // {
    //     //save user to user table
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password)
    //     ]);

    //     $token = $user->createToken('token')->plainTextToken;
    //     //return token
    //     return new LoginResource([
    //         'token' => $token,
    //         'user' => $user
    //     ]);
    // }

    //logout
    public function logout(Request $request)
    {
        // Hapus hanya token aktif, bukan semua token pengguna
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
