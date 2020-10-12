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

Route::get('/', function () {
    return view('welcome');
});

// **************************
// Se refactoriza este codigo
// **************************
// Route::post('/posts',           'PostController@store');
// Route::get('/posts',            'PostController@index');
// Route::get('/posts/{post}',     'PostController@show');
// Route::put('/posts/{post}',     'PostController@update');
// Route::delete('/posts/{post}',  'PostController@destroy');

Route::resource('/posts', 'PostController');