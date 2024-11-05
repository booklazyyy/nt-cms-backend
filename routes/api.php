<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    AuthController,
    PostController,
    PostMetumController,
    BlockController,
    OrganizationController,
    UserHasOrganizationController,
    UserMetumController,
    TemplateController,
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    // Route::post('/login', [AuthController::class, 'login']);
    
    // Route::group([

    //     'middleware' => 'api',
    //     'namespace'  => 'App\Http\Controllers',
    //     'prefix' => 'auth'
    
    // ], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function () {
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
    // });
    
    Route::apiResource('posts', PostController::class);
    Route::apiResource('postmeta', PostMetumController::class);
    Route::apiResource('blocks', BlockController::class);
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('user-has-organizations', UserHasOrganizationController::class);
    Route::apiResource('usermeta', UserMetumController::class);
    Route::apiResource('templates', TemplateController::class);
    

});
