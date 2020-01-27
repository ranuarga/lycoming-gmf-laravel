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

Route::get('/', function () {
    return "Welcome to Lycoming GMF KSO Surabaya's API";
});

Route::get('admin', 'AdminController@all')->name('admin.all');
Route::get('admin/{id}', 'AdminController@show')->name('admin.show');
Route::post('admin', 'AdminController@store')->name('admin.store');
Route::put('admin/{id}', 'AdminController@update')->name('admin.update');
Route::delete('admin/{id}', 'AdminController@delete')->name('admin.delete');