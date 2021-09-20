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


Route::group(['middleware' => ['jwt.verify']], function () {
 
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
    // Route::resource('spikpa', 'spikpa\SpikpaController')->middleware('log.route');
    // Route::resource('vcs', 'vcs\VcsController')->middleware('log.route');
    // Route::resource('bms', 'bms\BmsController')->middleware('log.route');
    Route::resource('spikpa', 'spikpa\SpikpaController');
    Route::resource('vcs', 'vcs\VcsController');
    Route::resource('bms', 'bms\BmsController');
});
