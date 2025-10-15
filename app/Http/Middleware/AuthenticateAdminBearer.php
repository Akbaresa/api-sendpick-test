<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;
use Carbon\Carbon;

class AuthenticateAdminBearer
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized - Missing Bearer Token'], 401);
        }

        $token = substr($authHeader, 7);

        $userToken = Token::with('user.role')
            ->where('token', $token)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->first();

        if (!$userToken) {
            return response()->json(['message' => 'Unauthorized - Invalid or expired token'], 401);
        }

        $user = $userToken->user;

        if (!$user || $user->role_id !== 1) {
            return response()->json(['message' => 'Forbidden - Admins only'], 403);
        }
        
        $userToken->update(['last_used_at' => Carbon::now()]);

        Auth::login($user);

        return $next($request);
    }
}
