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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('login', 'Auth\AuthController@login');
    //Route::post('register','Auth\AuthController@register');
    //Route::post('change-password/{user:email}', 'Auth\ForgetPasswordController@changePassword');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('admins', 'AdminController');
        Route::get('admins', 'AdminController@index');
        Route::post('admins', 'AdminController@store');
        Route::post('admins/update-info','AdminController@updateInfo');
        Route::post('admins/update-password','AdminController@updatePassword');
        Route::get('admin', 'AdminController@show');
        Route::post('delete/admin/{admin}', 'AdminController@destroy');
        Route::post('logout', 'Auth\AuthController@logout');
    });
});
