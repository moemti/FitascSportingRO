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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('/saveMyInfo', 'App\Http\Controllers\PersonController@saveMyInfo');

Route::POST('/modificaparola', 'App\Http\Controllers\PersonController@modificaparolaApi');

Route::POST('/stergecont', 'App\Http\Controllers\PersonController@stergecontApi');

Route::POST('/addtranslation', 'App\Http\Controllers\TranslationController@addTranslationDB');

Route::POST('/gettranslationdb', 'App\Http\Controllers\TranslationController@getTranslationDB');

