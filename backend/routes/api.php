<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', 'AuthController@logout');

    Route::get('user', 'UserController@me');

    Route::apiResource('monitors', 'MonitorController')->only(['index', 'store', 'destroy']);
    Route::post('monitors/check', 'MonitorController@check');
});
