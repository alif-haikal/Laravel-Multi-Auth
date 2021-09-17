<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');



//admin
Route::group(['middleware' => 'is_admin'], function () {
    Route::resource('users', 'UserController');
    Route::get('/scopes/{id}', 'UserController@scopes')->name('users.scopes');
    Route::post('/scopesUpdate/{id}', 'UserController@scopesUpdate')->name('users.scopes.update');
    Route::get('/getScopeByRole', 'UserController@getScopeByRole')->name('users.scopes.by.role');
});


//user
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::get('generate_token', 'JwtController@authenticate')->name('generate_token');
});
