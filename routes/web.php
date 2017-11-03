<?php

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

Route::group(['middleware' => 'auth'], function () {
	Route::resource('quotes', 'QuoteController', ['except' => ['index', 'show']]);
	Route::post('quotes-comment/{id}', 'QuoteCommentController@store');
});


Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{id?}', 'HomeController@profile');
Route::get('quotes/random', 'QuoteController@random');

Route::resource('quotes', 'QuoteController', ['only' => ['index', 'show']]);


