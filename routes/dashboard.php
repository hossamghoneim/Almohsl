<?php

use Illuminate\Support\Facades\Route;

Route::group([ 'prefix' => 'dashboard' , 'namespace' => 'Dashboard', 'as' => 'dashboard.' , 'middleware' => ['web', 'auth:admin', 'set_locale' , 'update_admin_cache' ] ] , function (){

    /** set theme mode ( light , dark ) **/
    Route::get('/change-theme-mode/{mode}', 'SettingController@changeThemeMode');

    /** dashboard index **/
    Route::get('/' , 'DashboardController@index')->name('index');

    /** resources routes **/
    Route::resource('roles','RoleController');
    Route::resource('settings','SettingController')->only(['index','store']);

    /** ajax routes **/
    Route::get('role/{role}/admins','RoleController@admins');

    /** admin profile routes **/

    Route::view('edit-profile','dashboard.admins.edit-profile')->name('edit-profile');
    Route::put('update-profile', 'AdminController@updateProfile')->name('update-profile');
    Route::put('update-password', 'AdminController@updatePassword')->name('update-password');

    /** Trash routes */
    Route::get('trash/{modelName?}','TrashController@index')->name('trash');
    Route::get('trash/{modelName}/{id}','TrashController@restore');
    Route::delete('trash/{modelName}/{id}','TrashController@forceDelete');

    Route::get('trash/{modelName}/{id}/restore','TrashController@restore')->name('trash.restore');
    Route::delete("admins/delete-selected", "AdminController@deleteSelected");
    Route::get("admins/restore-selected", "AdminController@restoreSelected");
    Route::resource('admins','AdminController')->except(['create', 'edit']);
    Route::get('select/ajax/roles', "AdminController@selectAjaxRoles")->name('select2_ajax.roles');
});
