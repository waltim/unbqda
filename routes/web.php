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
Route::put('/project', 'ProjectController@update')->name('project.update')->middleware('auth');
Route::get('/advanced-stage/{project}', 'ProjectController@advanced_stage')->name('project.advanced.stage')->middleware('auth');

Route::resource('interview', 'InterviewController')->middleware('auth');
Route::put('/interview', 'InterviewController@update')->name('interview.update')->middleware('auth');
Route::get('/code-analise/{interview}', 'InterviewController@analise')->name('interview.analise')->middleware('auth');
Route::get('/observations/{code}', 'InterviewController@observations')->name('interview.observation')->middleware('auth');
Route::post('/remove-code-quote', 'CodeController@remove_code_quote')->name('code.quote.remove')->middleware('auth');

Route::resource('code', 'CodeController')->middleware('auth');
Route::get('/code-highlight/{interview}', 'CodeController@highlight')->name('code.highlight')->middleware('auth');
Route::post('/analise', 'CodeController@analise')->name('code.analise')->middleware('auth');
Route::post('/observation-store', 'CodeController@save_observation')->name('code.observation')->middleware('auth');
Route::post('/code-store-selected', 'CodeController@store_code_selected')->name('code.store.selected')->middleware('auth');
Route::get('/options-code/{interview}', 'CodeController@options_code')->name('options.code')->middleware('auth');
Route::delete('/analise-delete/{agreement}', 'CodeController@analise_delete')->name('code.analise.delete')->middleware('auth');

Route::resource('category', 'CategoryController')->middleware('auth');
Route::post('/code-link-categories', 'CategoryController@code_link_categories')->name('code.link.categories')->middleware('auth');
Route::post('/code-deslink-categories', 'CategoryController@deslink_categories')->name('deslink.categories')->middleware('auth');
Route::get('/show-categories/{code}', 'CategoryController@categories_options_link')->name('categories.options.link')->middleware('auth');
Route::get('/show-categories-deslink/{code}', 'CategoryController@categories_options_deslink')->name('categories.options.deslink')->middleware('auth');
Route::put('/category', 'CategoryController@update')->name('category.update')->middleware('auth');
Route::get('/options-category/{category}', 'CategoryController@options_category')->name('options.category')->middleware('auth');


Route::get('/theory', 'ProjectController@theory')->name('project.theory')->middleware('auth');

Auth::routes(['register' => false]);
// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




