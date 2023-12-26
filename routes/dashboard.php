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
    Route::delete('mini-trackers/delete-selected', "MiniTrackerController@deleteSelected");
    Route::resource('mini-trackers', 'MiniTrackerController')->only(['index','store', 'update', 'destroy']);
    Route::post('upload-mini-file', 'MiniTrackerController@upload_excel_file')->name('upload-mini-file');
    Route::delete('big-trackers/delete-selected', "BigTrackerController@deleteSelected");
    Route::resource('big-trackers', 'BigTrackerController')->only(['index','store', 'update', 'destroy', 'show']);
    Route::post('upload-big-file', 'BigTrackerController@upload_excel_file')->name('upload-big-file');
    Route::delete('matched-cars/delete-selected', "MatchedCarController@deleteSelected");
    Route::resource('matched-cars', 'MatchedCarController')->only(['index', 'show', 'destroy']);

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
