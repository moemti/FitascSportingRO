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
    return view('welcome');
})->name('welcome');
Route::get('/competitii', function () {
    return view('modules.pages.competitii');
})->name('competitii');

Route::get('/lasamente', function () {
    return view('modules.pages.clasamente');
})->name('clasamente');

Route::get('/regulamente', function () {
    return view('modules.pages.regulamente');
})->name('regulamente');

Route::get('/poligoane', function () {
    return view('modules.pages.poligoane');
})->name('poligoane');

Route::get('antrenamente', function () {
    return view('modules.pages.antrenamente');
})->name('antrenamente');

