<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::group(['prefix' => 'auth',], function () {
        Route::post('getToken', [App\Http\Controllers\Api\V1\AuthController::class, 'getToken']);

    });
    Route::group(['prefix' => 'test',], function () {
        Route::get('noAuth', [App\Http\Controllers\Api\V1\TestController::class, 'noAuth']);

    });
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1','middleware' => "auth:sanctum"], function () {
    Route::group(['prefix' => 'test',], function () {
        Route::get('auth', [App\Http\Controllers\Api\V1\TestController::class, 'auth']);
    });
    Route::group(['prefix' => 'company',], function () {
        Route::post('create', [App\Http\Controllers\Api\V1\CompanyController::class, 'create']);
        Route::get('index', [App\Http\Controllers\Api\V1\CompanyController::class, 'index']);
    });
});
