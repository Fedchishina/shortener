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
Auth::routes();
Route::get('/', 'Controller@getIndex');

//-- urls --
Route::post('/url/generate', 'UrlController@postUrlGenerate')->name('generate');
Route::group([
    'middleware' => 'check_edit_url'
], function () {
    Route::post('/url/edit', 'UrlController@postUrlEdit')->name('edit');
});


Route::get('/{url}', 'UrlController@getUrlRedirect');
Route::get('/url/error', 'UrlController@getUrlErrorMessage')->name('url-error-message');
