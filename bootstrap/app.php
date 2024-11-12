<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        // $middleware->priority([
        //     \App\Http\Middleware\JWTAuthMiddleware::class,
        //     \App\Http\Middleware\JWTRefreshMiddleware::class,
        //     \Spatie\Permission\Middleware\RoleMiddleware::class,
        //     \Spatie\Permission\Middleware\PermissionMiddleware::class,
        //     \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e, $request) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        });
        $exceptions->renderable(function (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException $e, $request) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        });
        $exceptions->renderable(function (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e, $request) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getCode());
        });
        $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => $e->getMessage(),
                'code' => 403,
            ], 403);
        });
    })->create();
