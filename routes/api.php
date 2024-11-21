<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// controller
use App\Http\Controllers\Api\{
    AuthController,
    PostController,
    PostMetaController,
    BlockController,
    OrganizationController,
    UserHasOrganizationController,
    UserMetaController,
    TemplateController,
};
// middleware
use App\Http\Middleware\{
    JWTAuthMiddleware,
    JWTRefreshMiddleware
};

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    // Route::post('/login', [AuthController::class, 'login']);

    // Route::group([

    //     'middleware' => 'api',
    //     'namespace'  => 'App\Http\Controllers',
    //     'prefix' => 'auth'

    // ], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware(JWTRefreshMiddleware::class)
            ->post('refresh', [AuthController::class, 'refresh']);
    });
    Route::apiResources([
        'posts' => PostController::class,
        'postmeta' => PostMetaController::class,
        'blocks' => BlockController::class,
        'rganizations' => OrganizationController::class,
        'user-has-organizations' => UserHasOrganizationController::class,
        'usermeta' => UserMetaController::class,
        'templates' => TemplateController::class
    ]);
    Route::middleware([JWTAuthMiddleware::class])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::delete('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });

        // Route::apiResources([
        //     'posts' => PostController::class,
        //     'postmeta' => PostMetaController::class,
        //     'blocks' => BlockController::class,
        //     'rganizations' => OrganizationController::class,
        //     'user-has-organizations' => UserHasOrganizationController::class,
        //     'usermeta' => UserMetaController::class,
        //     'templates' => TemplateController::class
        // ]);
    });
});
