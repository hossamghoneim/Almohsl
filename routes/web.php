<?php

use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{lang}', [SettingController::class, 'changeLanguage'])->name('change-language');

Route::group(['namespace' => 'Auth' , 'middleware' => 'set_locale'] , function () {

    // admin login routes
    Route::get('admin/login','AdminAuthController@showLoginForm')->name('admin.login-form');
    Route::post('admin/login','AdminAuthController@login')->name('admin.login');
    Route::post('admin/logout','AdminAuthController@logout')->name('admin.logout');

    // user login routes
    Route::get('admin/login','AdminAuthController@showLoginForm')->name('admin.login-form');

});


Route::group(['namespace' => 'Home' , 'middleware' => 'set_locale'] , function () {

    Route::get('/','HomeController@index')->name('home.index');


});



