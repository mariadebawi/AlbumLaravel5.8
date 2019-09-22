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

/*
Route::get('/', function () {
    return view('welcome');
});

*/

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');

//Route::get('/', 'HomeController@index')->name('home')->middleware('verified');



Route::middleware('admin')->group(function () {
    Route::resource ('category', 'CategoryController', [
        'except' => 'show'
    ]);
});


Route::middleware ('auth', 'verified')->group (function () {
    Route::resource ('image', 'ImageController', [
        'only' => ['create', 'store', 'destroy', 'update']
    ]);
});

Route::name('category')->get('category/{slug}', 'ImageController@category');

Route::name ('user')->get ('user/{user}', 'ImageController@user');

Route::name ('image.')->middleware ('ajax')->group (function () {
    Route::prefix('image')->group(function () {
        Route::name ('description')->put ('{image}/description', 'ImageController@descriptionUpdate');
        Route::name ('adult')->put ('{image}/adult', 'ImageController@adultUpdate');

    });
});


Route::middleware ('auth', 'verified')->group (function () {
    Route::resource('profile', 'ProfileController', [
        'only' => ['edit', 'update', 'destroy', 'show'],
        'parameters' => ['profile' => 'user']
    ]);
});

Route::middleware ('auth', 'verified')->group (function () {
    Route::resource('album', 'AlbumController', [
        'except' => 'show'
    ]);
}) ;
