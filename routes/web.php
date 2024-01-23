<?php

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/events', 'App\Http\Controllers\EventController@index')->name('events.index');
Route::get('/events/{event}', 'App\Http\Controllers\EventController@show')->name('events.show');
Route::get('/events/{event}/participate', 'App\Http\Controllers\EventController@participate')->name('events.participate');
Route::post('/events/{event}/participate', 'App\Http\Controllers\EventController@storeParticipation')->name('events.storeParticipation');
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
