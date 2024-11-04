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

    Route::post('/login', [AuthController::class, 'login']);
    
    Route::apiResource('posts', PostController::class);
    Route::apiResource('postmeta', PostMetumController::class);
    Route::apiResource('blocks', BlockController::class);
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('user-has-organizations', UserHasOrganizationController::class);
    Route::apiResource('usermeta', UserMetumController::class);
    Route::apiResource('templates', TemplateController::class);
    

});
