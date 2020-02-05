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

Route::get('home', 'HomeController@index')->name('home');

Route::get('admin', 'AdminController@index')->name('admin');
Route::get('admin/create', 'AdminController@create')->name('admin.create');
Route::post('admin/store', 'AdminController@storeWeb')->name('admin.store');
Route::post('admin/{id}/update', 'AdminController@updateWeb')->name('admin.update');
Route::get('admin/{id}/delete', 'AdminController@destroy')->name('admin.delete');