<?php

use Illuminate\Support\Facades\Route;



Route::get('/',  'App\Http\Controllers\CompetitiiController@returnWelcome')->name('welcome');

Route::get('/welcome',  'App\Http\Controllers\CompetitiiController@returnWelcome')->name('welcome');


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

Route::get('/termeni', function (){
    return view('modules/pages/termeni');

})->name('termeni');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// o sa-l punem in superuser

        Route::get('/registeries', 'App\Http\Controllers\Auth\LoginController@getregisteries')->name('registeries');
        Route::get('/registere/{id}', 'App\Http\Controllers\Auth\LoginController@getregistere');
        Route::post('registere/finishuser', 'App\Http\Controllers\Auth\LoginController@finishuser');


// permisiune de editare competitii
        Route::get('/editresult/{id}', 'App\Http\Controllers\CompetitiiController@editresult');
        
        Route::post('/getresultajax', 'App\Http\Controllers\CompetitiiController@getresultajax');



        Route::post('/changeCompetitionStatus', 'App\Http\Controllers\CompetitiiController@changeCompetitionStatus');
        Route::post('/doCompetitionSquads', 'App\Http\Controllers\CompetitiiController@doCompetitionSquads');
        

        Route::post('/registerMe', 'App\Http\Controllers\CompetitiiController@registerMe');
        Route::post('/registerCompetitor', 'App\Http\Controllers\CompetitiiController@registerCompetitor');
        Route::post('/registerCompetitor/{PersonId}', 'App\Http\Controllers\CompetitiiController@registerCompetitor');
        Route::post('/registerCompetitorDB', 'App\Http\Controllers\CompetitiiController@registerCompetitorDB');

        Route::post('/getresultdetailsajax', 'App\Http\Controllers\CompetitiiController@getresultdetailsajax');
        Route::post('/saveresultdetail', 'App\Http\Controllers\ResultsController@saveitemajax');
        Route::post('/deleteresultajax', 'App\Http\Controllers\ResultsController@deleteitemajax');
        
        Route::get('/gallery/{id}', 'App\Http\Controllers\CompetitiiController@getgallery');
        



    Route::get('/clasamente', 'App\Http\Controllers\ClasamenteController@getClasamente');

    Route::post('/getClasamentByYear', 'App\Http\Controllers\ClasamenteController@getClasamentByYear');


    //Route::POST('/competition', 'App\Http\Controllers\CompetitiiController@getItemAjax');
    Route::GET('/clasament/{id}', 'App\Http\Controllers\CompetitiiController@getClasament');
    Route::GET('/clasamentdata/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentdata');
    Route::GET('/competitionListDown/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentList');


    Route::get('/poligon/{id}', 'App\Http\Controllers\NavigationController@getPoligon');

    Route::middleware(['guest'])->group(function(){

            // my user
            Route::get('/myuser', 'App\Http\Controllers\PersonController@getmyuser')->name('myuser');
            Route::post('/savemyuser', 'App\Http\Controllers\PersonController@savemyuser');
            Route::post('/getmyuserajax', 'App\Http\Controllers\PersonController@getmyuserajax');
            Route::post('/changemypassword', 'App\Http\Controllers\PersonController@changemypassvord');

            // persoane
            Route::get('/persoane', 'App\Http\Controllers\PersonController@getList');

            Route::post('savepersonajax', 'App\Http\Controllers\PersonController@saveitemajax');
            Route::post('getpersonsajax', 'App\Http\Controllers\PersonController@getitemsajax');
            Route::post('getpersonajax', 'App\Http\Controllers\PersonController@getitemajax');
            Route::post('deletepersonajax', 'App\Http\Controllers\PersonController@deleteitemajax');
            Route::post('getpersondetaillistajax', 'App\Http\Controllers\PersonController@getdetaillistajax');


            


    });

    Route::get('{page}', 'App\Http\Controllers\NavigationController@getPage'); 

