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
    return view('modules.pages.welcome');
})->name('welcome');


Route::get('/competitii', 'App\Http\Controllers\CompetitiiController@getList');


Route::get('/clasamente', 'App\Http\Controllers\ClasamenteController@getClasamente');

//Route::POST('/competition', 'App\Http\Controllers\CompetitiiController@getItemAjax');
Route::GET('/clasament/{id}', 'App\Http\Controllers\CompetitiiController@getClasament');

Route::get('/poligon/{id}', 'App\Http\Controllers\NavigationController@getPoligon');


Route::get('{page}', 'App\Http\Controllers\NavigationController@getPage'); 

