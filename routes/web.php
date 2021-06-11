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
    return view('site.principal',['titulo' => 'Bem-vindo ao grupo!']);
})->name('principal');

Route::fallback(function(){
    return 'Desculpe, página não encontrada.';
});

Route::resource('project', 'ProjectController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




