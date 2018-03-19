<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
    Route::auth();

	Route::get('/home', 'HomeController@index');
    
    Route::get('/threads/create', 'ThreadController@create');

    Route::get('/profiles/{user}', 'profilesController@show');

    Route::post('images/{user}', 'profileImagesController@store')->name('upload-image');

    Route::get('/threads/{channel?}', 'ThreadController@index');
  
    Route::post('/threads', 'ThreadController@store');

    Route::get('/threads/{channel}/{thread}', 'ThreadController@show');

    Route::delete('/threads/{id}', 'ThreadController@destroy');

    Route::post('/threads/{channel}/{thread}/subscriptions', 'SubscribeController@store');

    Route::delete('/threads/{channel}/{thread}/subscriptions', 'SubscribeController@destroy');

    Route::get('/notifications', 'NotificationsController@index');

    Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->name('add_reply');

    Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('delete_reply');

    Route::get('replies/{reply}/edit', 'ReplyController@edit')->name('edit_reply');

    Route::put('replies/{reply}/mark', 'markReplyController@store')->name('mark-reply');

    Route::delete('replies/{reply}/unmark', 'markReplyController@destroy');

    Route::put('replies/{reply}/update', 'ReplyController@update')->name('update_reply');

    Route::post('/replies/{reply}/like', 'likesController@store');

    Route::get('/', function () {
    
    return view('welcome');
});
});


