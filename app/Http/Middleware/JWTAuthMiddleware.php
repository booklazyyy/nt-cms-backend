<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;



class JWTAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::getJWTProvider()->setSecret(env('JWT_ACCESS_SECRET'));
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw new JWTException($e->getMessage(), 401);
        }

        return $next($request);
    }
}
