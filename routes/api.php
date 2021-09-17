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

// Route::post('register', 'UserController@register');
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('closed', 'DataController@closed');
 
/*
REFERENCE

    Verb          Path                         Action  Route Name       Status
    GET           /spikpa                      index   spikpa.index     (used)
    GET           /spikpa/create               create  spikpa.create
    POST          /spikpa                      store   spikpa.store     (used)
    GET           /spikpa/{user}               show    spikpa.show      (used)
    GET           /spikpa/{user}/edit          edit    spikpa.edit
    PUT|PATCH     /spikpa/{user}               update  spikpa.update    (used)
    DELETE        /spikpa/{user}               destroy spikpa.destroy   (used)
*/
    Route::resource('spikpa', 'spikpa\SpikpaController');
    Route::resource('vcs', 'vcs\VcsController');
    Route::resource('bms', 'bms\BmsController');

});
