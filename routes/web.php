<?php

use Illuminate\Http\Request;

Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['role:Admin|Editor|Viewer']], function () {
    Route::resource('list', 'ListController');
});

Auth::routes();

// This secondary logout is to catch naughty people that try to use the /logout link directly
// If this was not here then they would see the Laravel "Not Allowed" error page
// The proper Laravel auth logout is handled via POST since 5.4 (handled by the route before these comments)
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');