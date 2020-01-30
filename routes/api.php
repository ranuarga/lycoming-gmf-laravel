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

Route::get('engineer', 'EngineerController@all')->name('engineer.all');
Route::get('engineer/{id}', 'EngineerController@show')->name('engineer.show');
Route::post('engineer', 'EngineerController@store')->name('engineer.store');
Route::put('engineer/{id}', 'EngineerController@update')->name('engineer.update');
Route::delete('engineer/{id}', 'EngineerController@delete')->name('engineer.delete');

Route::get('engine-model', 'EngineModelController@all')->name('engine-model.all');
Route::get('engine-model/{id}', 'EngineModelController@show')->name('engine-model.show');
Route::post('engine-model', 'EngineModelController@store')->name('engine-model.store');
Route::put('engine-model/{id}', 'EngineModelController@update')->name('engine-model.update');
Route::delete('engine-model/{id}', 'EngineModelController@delete')->name('engine-model.delete');

Route::get('job', 'JobController@all')->name('job.all');
Route::get('job/done', 'JobController@allDone')->name('job.all-done');
Route::get('job/progress', 'JobController@allProgress')->name('job.all-progress');
Route::get('job/{id}', 'JobController@show')->name('job.show');
Route::post('job', 'JobController@store')->name('job.store');
Route::put('job/{id}', 'JobController@update')->name('job.update');
Route::delete('job/{id}', 'JobController@delete')->name('job.delete');

Route::get('job-order', 'JobOrderController@all')->name('job-order.all');
Route::get('job-order/{id}', 'JobOrderController@show')->name('job-order.show');
Route::post('job-order', 'JobOrderController@store')->name('job-order.store');
Route::put('job-order/{id}', 'JobOrderController@update')->name('job-order.update');
Route::delete('job-order/{id}', 'JobOrderController@delete')->name('job-order.delete');

Route::get('job-sheet', 'JobSheetController@all')->name('job-sheet.all');
Route::get('job-sheet/{id}', 'JobSheetController@show')->name('job-sheet.show');
Route::post('job-sheet', 'JobSheetController@store')->name('job-sheet.store');
Route::put('job-sheet/{id}', 'JobSheetController@update')->name('job-sheet.update');
Route::delete('job-sheet/{id}', 'JobSheetController@delete')->name('job-sheet.delete');

Route::get('management', 'ManagementController@all')->name('management.all');
Route::get('management/{id}', 'ManagementController@show')->name('management.show');
Route::post('management', 'ManagementController@store')->name('management.store');
Route::put('management/{id}', 'ManagementController@update')->name('management.update');
Route::delete('management/{id}', 'ManagementController@delete')->name('management.delete');

Route::get('progress-job', 'ProgressJobController@all')->name('progress-job.all');
Route::get('progress-job/{id}', 'ProgressJobController@show')->name('progress-job.show');
// Progress Job created when we create Job so probably we not this method for production,
// but for development I think i need it so I put it here.
Route::post('progress-job', 'ProgressJobController@store')->name('progress-job.store');
Route::put('progress-job/{id}', 'ProgressJobController@update')->name('progress-job.update');
Route::put('progress-job/{id}/note', 'ProgressJobController@updateNote')->name('progress-job.update-note');
Route::put('progress-job/{id}/remark', 'ProgressJobController@updateStatusAndRemark')->name('progress-job.update-remark');
Route::delete('progress-job/{id}', 'ProgressJobController@delete')->name('progress-job.delete');

Route::get('progress-status', 'ProgressStatusController@all')->name('progress-status.all');
Route::get('progress-status/{id}', 'ProgressStatusController@show')->name('progress-status.show');
Route::post('progress-status', 'ProgressStatusController@store')->name('progress-status.store');
Route::put('progress-status/{id}', 'ProgressStatusController@update')->name('progress-status.update');
Route::delete('progress-status/{id}', 'ProgressStatusController@delete')->name('progress-status.delete');