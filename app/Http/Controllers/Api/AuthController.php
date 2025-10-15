<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(UserLoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->error('Invalid credentials', 401);
            }

            $token = Str::random(60);
            $user->update(['api_token' => $token]);

            return $this->success([
                'token' => $token,
                'user' => $user
            ], 'Login successful');

        } catch (Exception $e) {
            return $this->error('Gagal Melakukan Autentikasi', 500);
        }
    }
}
