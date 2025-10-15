<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;

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

            Token::create([
                'user_id' => $user->id_user,
                'token' => $token,
                'expired_at' => Carbon::now()->addHours(7),
                'device_name' => $request->header('User-Agent'),
                'last_used_at' => now(),
            ]);

            return $this->success([
                'token' => $token,
                'user' => $user,
                'expired_at' => Carbon::now()->addHours(7)->toDateTimeString()
            ], 'Login successful');
        } catch (\Throwable $e) {
            return $this->error('Login failed: ' . $e->getMessage(), 500);
        }
    }
}
