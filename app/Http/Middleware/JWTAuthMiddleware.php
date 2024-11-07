<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;


class JWTAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            config()->set('jwt.secret', env('JWT_ACCESS_SECRET'));
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not valid', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
