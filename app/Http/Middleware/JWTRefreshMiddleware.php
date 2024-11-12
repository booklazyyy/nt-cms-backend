<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Response;

class JWTRefreshMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refresh_token = $request->input('refresh_token');
        if (!$refresh_token) {
            return response()->json([
                'error' => 'Refresh token not provided!',
            ], 400);
        }
        try {
            // config()->set('jwt.secret', env('JWT_REFRESH_SECRET'));
            JWTAuth::getJWTProvider()->setSecret(env('JWT_REFRESH_SECRET'));
            JWTAuth::setToken($refresh_token)->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => $e->getMessage(), 'message' => 'Please Login!', 'code' => 401], 401);
        } catch (JWTException $e) {
            throw new JWTException($e->getMessage(), 401);
        }

        return $next($request);
    }
}
