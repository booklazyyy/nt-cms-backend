<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostMetumController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\UserHasOrganizationController;
use App\Http\Controllers\Api\UserMetumController;
use App\Http\Controllers\Api\TemplateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::apiResource('posts', PostController::class);
    Route::apiResource('postmeta', PostMetumController::class);
    Route::apiResource('blocks', BlockController::class);
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('user-has-organizations', UserHasOrganizationController::class);
    Route::apiResource('usermeta', UserMetumController::class);
    Route::apiResource('templates', TemplateController::class);

});
