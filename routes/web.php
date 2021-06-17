<?php

use Illuminate\Support\Facades\Auth;
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
Route::put('/project', 'ProjectController@update')->name('project.update');
Route::get('/advanced-stage/{project}', 'ProjectController@advanced_stage')->name('project.advanced.stage');

Route::resource('interview', 'InterviewController')->middleware('auth');
Route::put('/interview', 'InterviewController@update')->name('interview.update');
Route::get('/code-analise/{interview}', 'InterviewController@analise')->name('interview.analise');

Route::resource('code', 'CodeController')->middleware('auth');
Route::get('/code-highlight/{interview}', 'CodeController@highlight')->name('code.highlight');
Route::post('/analise', 'CodeController@analise')->name('code.analise');
Route::delete('/analise-delete/{agreement}', 'CodeController@analise_delete')->name('code.analise.delete');

Route::resource('category', 'CategoryController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




