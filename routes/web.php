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


Route::get('/login', function(){  return view('auth/login');})->name('login');

Route::post('/authenticate', 'App\Http\Controllers\Auth\LoginController@authenticate');
Route::post('/registerme', 'App\Http\Controllers\Auth\LoginController@register');
Route::post('/resetpassword', 'App\Http\Controllers\Auth\LoginController@resetpasswordmail');
Route::get('/confirmregistration', 'App\Http\Controllers\Auth\LoginController@confirmregistrationemail');
Route::get('/changepassword', 'App\Http\Controllers\Auth\LoginController@changepassword');
Route::post('/changethepassword', 'App\Http\Controllers\Auth\LoginController@changethepassword');


Route::get('/resetform', function (){
    return view('auth/reset');

})->name('resetpassword');

Route::get('/register', function (){
    return view('auth/register');

})->name('register');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// o sa-l punem in superuser
        Route::get('/registeries', 'App\Http\Controllers\Auth\LoginController@getregisteries')->name('registeries');
        Route::get('/registere/{id}', 'App\Http\Controllers\Auth\LoginController@getregistere');
        Route::post('registere/finishuser', 'App\Http\Controllers\Auth\LoginController@finishuser');


Route::get('/clasamente', 'App\Http\Controllers\ClasamenteController@getClasamente');

//Route::POST('/competition', 'App\Http\Controllers\CompetitiiController@getItemAjax');
Route::GET('/clasament/{id}', 'App\Http\Controllers\CompetitiiController@getClasament');

Route::get('/poligon/{id}', 'App\Http\Controllers\NavigationController@getPoligon');

Route::middleware(['guest'])->group(function(){

        // my user
        Route::get('/myuser', 'App\Http\Controllers\PersonController@getmyuser')->name('myuser');
        Route::post('/savemyuser', 'App\Http\Controllers\PersonController@savemyuser');
        Route::post('/getmyuserajax', 'App\Http\Controllers\PersonController@getmyuserajax');
        Route::post('/changemypassword', 'App\Http\Controllers\PersonController@changemypassvord');



       

});

Route::get('{page}', 'App\Http\Controllers\NavigationController@getPage'); 

