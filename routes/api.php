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
        Route::get('/current', function (Request $request) {
            return auth()->user();
        });
        Route::post('logout', 'Auth\AuthController@logout');
        //Route::post('/users/update-info','ProfileController@updateInfo');
        //Route::post('/users/update-password','ProfileController@updatePassword');
    });
});
