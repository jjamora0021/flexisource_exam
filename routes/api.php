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


// Fetch Players then Store on DB
Route::get('fetch/players','PlayersController@index');

// Fetch All Players
Route::get('players','PlayersController@showAll');
// Fetch data on a Specif Player
Route::get('players/{id}','PlayersController@show');