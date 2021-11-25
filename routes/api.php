<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'ApiAuthController@login');
Route::post('register', 'ApiAuthController@register');
// Route::get('logout', 'ApiAuthController@logout');
// Route::get('userInfo', 'ApiAuthController@userInfo')->middleware('auth:api');
Route::group(['middleware' => 'auth:api'], function() {
	Route::get('logout', 'ApiAuthController@logout');
	//USER
	Route::get('userInfo', 'ApiAuthController@userInfo');
	Route::get('users', 'Api\UserController@index');
	Route::post('users/stores', 'Api\UserController@store');
	Route::get('users/{id}', 'Api\UserController@show');
	Route::post('users/update/{id}', 'Api\UserController@update');
	Route::delete('users/delete/{id}', 'Api\UserController@destroy');
	//UPLOAD
	Route::get('upload/list', 'Api\UploadController@list');
	Route::post('upload/create', 'Api\UploadController@create');

});
// Route::get('users', 'Api\UserController@index');
// Route::post('users/stores', 'Api\UserController@store');
// Route::get('users/{id}', 'Api\UserController@show');
// Route::post('users/update/{id}', 'Api\UserController@update');
// Route::delete('users/delete/{id}', 'Api\UserController@destroy');