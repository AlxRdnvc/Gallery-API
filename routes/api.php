<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], 

function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'UserController@store');

    Route::get('galleries', 'GalleryController@index');
    Route::get('galleries/{id}', 'GalleryController@show');
    Route::get('authors/{id}', 'GalleryController@AuthorGalleries');
    Route::post('galleries', 'GalleryController@store');
    Route::get('my-galleries', 'GalleryController@UserGalleries');
    Route::delete('galleries/{id}', 'GalleryController@destroy');

    Route::post('comments', 'CommentController@store');
    Route::delete('comments/{id}', 'CommentController@destroy');

});
