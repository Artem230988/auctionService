<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('lots.index');
});

Route::get('/lots', 'LotsController@index')->name('lots.index');
Route::get('/lots/old', 'LotsController@indexOld')->name('lots.indexOld');
Route::get('/lots/new', 'LotsController@indexNew')->name('lots.indexNew');
Route::get('/lots/myLots', 'LotsController@indexMyLots')->name('lots.indexMyLots');

Route::get('/lots/create', 'LotsController@create')->name('lots.create');
Route::get('/lots/{lot}', 'LotsController@show')->name('lots.show');
Route::get('/lots/{lot}/editRate', 'LotsController@editRate')->name('lots.editRate');
Route::get('/lots/{lot}/edit', 'LotsController@edit')->name('lots.edit');
Route::patch('/lots/{lot}', 'LotsController@update')->name('lots.update');
Route::patch('/lots/{lot}/updateRate', 'LotsController@updateRate')->name('lots.updateRate');
Route::patch('/lots/{lot}/stopLot', 'LotsController@stopLot')->name('lots.stopLot');
Route::post('lots', 'LotsController@store')->name('lots.store');


Route::delete('/images/{image}', 'ImagesController@destroy')->name('images.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
