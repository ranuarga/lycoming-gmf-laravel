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

Route::get('/', 'TrackController@index')->name('track');
Route::post('search', 'TrackController@search')->name('track.search');

Route::get('login',  'LoginController@loginForm')->name('login');
Route::post('login',  'LoginController@loginWeb')->name('login.post');

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

    Route::get('engine-model', 'EngineModelController@index')->name('engine-model');
    Route::get('engine-model/create', 'EngineModelController@create')->name('engine-model.create');
    Route::post('engine-model/store', 'EngineModelController@storeWeb')->name('engine-model.store');
    Route::post('engine-model/{id}/update', 'EngineModelController@updateWeb')->name('engine-model.update');
    Route::get('engine-model/{id}/edit', 'EngineModelController@edit')->name('engine-model.edit');
    Route::get('engine-model/{id}/delete', 'EngineModelController@destroy')->name('engine-model.delete');

    Route::get('job', 'JobController@index')->name('job');
    Route::get('job/done', 'JobController@allDoneWeb')->name('job.done');
    Route::get('job/on-progress', 'JobController@allProgressWeb')->name('job.on-progress');
    Route::get('job/create', 'JobController@create')->name('job.create');
    Route::post('job/store', 'JobController@storeWeb')->name('job.store');
    Route::post('job/{id}/update', 'JobController@updateWeb')->name('job.update');
    Route::get('job/{id}/edit', 'JobController@edit')->name('job.edit');
    Route::get('job/{id}/progress', 'ProgressJobController@progressByJobID')->name('job.progress');
    Route::get('job/{id}/progress/{pid}', 'ProgressJobController@progressDetail')->name('job.progress.detail');
    Route::get('job/{id}/progress/{pid}/edit', 'ProgressJobController@edit')->name('job.progress.edit');
    Route::post('progress-job/{id}/update', 'ProgressJobController@updateWeb')->name('job.progress.update');
    Route::get('job/{id}/delete', 'JobController@destroy')->name('job.delete');
    
    Route::get('job-order', 'JobOrderController@index')->name('job-order');
    Route::get('job-order/create', 'JobOrderController@create')->name('job-order.create');
    Route::post('job-order/store', 'JobOrderController@storeWeb')->name('job-order.store');
    Route::post('job-order/{id}/update', 'JobOrderController@updateWeb')->name('job-order.update');
    Route::get('job-order/{id}/edit', 'JobOrderController@edit')->name('job-order.edit');
    Route::get('job-order/{id}/delete', 'JobOrderController@destroy')->name('job-order.delete');
    
    Route::get('job-sheet', 'JobSheetController@index')->name('job-sheet');
    
    Route::get('management', 'ManagementController@index')->name('management');
    Route::get('management/create', 'ManagementController@create')->name('management.create');
    Route::post('management/store', 'ManagementController@storeWeb')->name('management.store');
    Route::post('management/{id}/update', 'ManagementController@updateWeb')->name('management.update');
    Route::get('management/{id}/edit', 'ManagementController@edit')->name('management.edit');
    Route::get('management/{id}/delete', 'ManagementController@destroy')->name('management.delete');

    Route::get('progress-status', 'ProgressStatusController@index')->name('progress-status');
});