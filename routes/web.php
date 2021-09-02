<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');



//admin
Route::group(['middleware' => 'is_admin'], function () {
    Route::get('admin/home', 'HomeController@adminHome')->name('admin.home');
    Route::get('logout', 'AuthController@logout')->name('logout');
});


//user
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('user.home');
    Route::get('logout', 'AuthController@logout')->name('logout');
});
