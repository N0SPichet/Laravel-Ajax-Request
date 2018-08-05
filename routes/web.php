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

Route::get('/', 'PageController@index')->name('home');
Route::get('/home', 'PageController@index');

Route::middleware(['guest'])->group(function() {
	Route::post('signup', 'UserController@userSignUp')->name('user.signup');
	Route::post('login', 'UserController@userSignIn')->name('login');
});

Route::middleware(['auth'])->group(function () {
	Route::prefix('user')->group(function () {
		Route::get('logout', 'UserController@userLogout')->name('logout');
	});
	Route::prefix('posts')->group(function () {
		Route::get('', 'PostController@index')->name('posts.index');
		Route::post('store', 'PostController@store')->name('posts.store');
		Route::post('update', 'PostController@update')->name('posts.update');
		Route::get('delete/{id}', 'PostController@delete')->name('posts.delete');
		Route::post('like', 'PostController@postLike')->name('posts.like');
	});
});

//Check Database Connection
Route::get('check-connection',function(){
	if(DB::connection()->getDatabaseName()){
		return "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
	}else{
		return 'Connection False !!';
	}
})->name('check-connection');