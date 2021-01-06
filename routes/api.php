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
Route::group(['prefix' => 'v1/user','namespace' => 'App\Http\Controllers\v1\user' ], function(){
//Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
//Route::get('/users', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

Route::group(['middleware' => 'auth:api'], function(){
    //List Todo
    Route::get('/todo', 'TodoController@index');
    //Create new Todo
    Route::post('/todo', 'TodoController@store');
    //Update Existing Todo
    Route::put('/todo/{todos}', 'TodoController@update');
    //Delete Existing Todo
    Route::delete('/todo/{todos}', 'TodoController@destroy');
});
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user;
// });
