<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($authHeader, 7);

        $userToken = Token::with('user')->where('token', $token)->first();

        if (!$userToken) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        if ($userToken->user === null) {
            return response()->json(['message' => 'User not found'], 401);
        }

        if ($userToken->isExpired()) {
            return response()->json(['message' => 'Token expired'], 401);
        }

        $userToken->update(['last_used_at' => now()]);

        Auth::login($userToken->user);

        return $next($request);
    }
}
