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

// Example from Laravel
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login',  'LoginController@loginForm')->name('login');
Route::post('login',  'LoginController@loginWeb')->name('login.post');
Route::get('/', 'HomeController@root')->name('root');

Route::group(['middleware' => 'auth:web-admin'], function() {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('logout',  'LoginController@logoutWeb')->name('logout');

    Route::get('admin', 'AdminController@index')->name('admin');
    Route::get('admin/create', 'AdminController@create')->name('admin.create');
    Route::post('admin/store', 'AdminController@storeWeb')->name('admin.store');
    Route::post('admin/{id}/update', 'AdminController@updateWeb')->name('admin.update');
    Route::get('admin/{id}/edit', 'AdminController@edit')->name('admin.edit');
    Route::get('admin/{id}/delete', 'AdminController@destroy')->name('admin.delete');
    
    Route::get('engineer', 'EngineerController@index')->name('engineer');
    Route::get('engineer/create', 'EngineerController@create')->name('engineer.create');
    Route::post('engineer/store', 'EngineerController@storeWeb')->name('engineer.store');
    Route::post('engineer/{id}/update', 'EngineerController@updateWeb')->name('engineer.update');
    Route::get('engineer/{id}/edit', 'EngineerController@edit')->name('engineer.edit');
    Route::get('engineer/{id}/delete', 'EngineerController@destroy')->name('engineer.delete');

    Route::get('job-sheet', 'JobSheetController@index')->name('job-sheet');
    
    Route::get('management', 'ManagementController@index')->name('management');
    Route::get('management/create', 'ManagementController@create')->name('management.create');
    Route::post('management/store', 'ManagementController@storeWeb')->name('management.store');
    Route::post('management/{id}/update', 'ManagementController@updateWeb')->name('management.update');
    Route::get('management/{id}/edit', 'ManagementController@edit')->name('management.edit');
    Route::get('management/{id}/delete', 'ManagementController@destroy')->name('management.delete');
});