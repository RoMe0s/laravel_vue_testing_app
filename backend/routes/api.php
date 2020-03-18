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

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::middleware('auth:airlock')->group(function () {
    Route::get('user', 'UserController@me');

    Route::apiResource('monitors', 'MonitorController')->only(['index', 'store', 'destroy']);
    Route::post('monitors/check', 'MonitorController@check');
});
