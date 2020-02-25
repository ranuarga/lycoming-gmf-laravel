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

// Example from Laravel
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return "Welcome to Lycoming GMF KSO Surabaya's API";
})->name('root');

Route::group(['prefix' => 'admin-side'], function() {
    Route::post('login', 'LoginController@loginAdmin');
    
    Route::group(['middleware' => 'auth:admin'], function() {
        Route::get('admin', 'AdminController@all');
        Route::get('admin/{id}', 'AdminController@show');
        Route::post('admin', 'AdminController@store');
        Route::put('admin/{id}', 'AdminController@update');
        Route::delete('admin/{id}', 'AdminController@delete');
    
        Route::get('engineer', 'EngineerController@all');
        Route::get('engineer/{id}', 'EngineerController@show');
        Route::post('engineer', 'EngineerController@store');
        Route::put('engineer/{id}', 'EngineerController@update');
        Route::delete('engineer/{id}', 'EngineerController@delete');
    
        Route::get('engine-model', 'EngineModelController@all');
        Route::get('engine-model/{id}', 'EngineModelController@show');
        Route::post('engine-model', 'EngineModelController@store');
        Route::put('engine-model/{id}', 'EngineModelController@update');
        Route::delete('engine-model/{id}', 'EngineModelController@delete');
    
        Route::get('job', 'JobController@all');
        Route::get('job/done', 'JobController@allDone');
        Route::get('job/progress', 'JobController@allProgress');
        Route::get('job/{id}', 'JobController@show');
        Route::post('job', 'JobController@store');
        Route::put('job/{id}', 'JobController@update');
        Route::delete('job/{id}', 'JobController@delete');
        Route::get('job/{id}/progress', 'JobController@showProgress');
    
        Route::get('job-order', 'JobOrderController@all');
        Route::get('job-order/{id}', 'JobOrderController@show');
        Route::post('job-order', 'JobOrderController@store');
        Route::put('job-order/{id}', 'JobOrderController@update');
        Route::delete('job-order/{id}', 'JobOrderController@delete');
    
        Route::get('job-sheet', 'JobSheetController@all');
        Route::get('job-sheet/{id}', 'JobSheetController@show');
        Route::post('job-sheet', 'JobSheetController@store');
        Route::put('job-sheet/{id}', 'JobSheetController@update');
        Route::delete('job-sheet/{id}', 'JobSheetController@delete');
    
        Route::get('management', 'ManagementController@all');
        Route::get('management/{id}', 'ManagementController@show');
        Route::post('management', 'ManagementController@store');
        Route::put('management/{id}', 'ManagementController@update');
        Route::delete('management/{id}', 'ManagementController@delete');
    
        Route::get('progress-attachment', 'ProgressAttachmentController@all');
        Route::get('progress-attachment/{id}', 'ProgressAttachmentController@show');
        Route::post('progress-attachment', 'ProgressAttachmentController@store');
        Route::put('progress-attachment/{id}', 'ProgressAttachmentController@update');
        Route::delete('progress-attachment/{id}', 'ProgressAttachmentController@delete');
        
        Route::get('progress-job', 'ProgressJobController@all');
        Route::get('progress-job/{id}', 'ProgressJobController@show');
        // Progress Job created when we create Job so probably we not this method for production,
        // but for development I think i need it so I put it here.
        Route::post('progress-job', 'ProgressJobController@store');
        Route::put('progress-job/{id}', 'ProgressJobController@update');
        // The one who can only edit note is Management
        // Route::put('progress-job/{id}/note', 'ProgressJobController@updateNote');
        // The one who can only edit remark & status is Engineer
        // Route::put('progress-job/{id}/remark', 'ProgressJobController@updateStatusAndRemark');
        Route::delete('progress-job/{id}', 'ProgressJobController@delete');
    
        Route::get('progress-status', 'ProgressStatusController@all');
        Route::get('progress-status/{id}', 'ProgressStatusController@show');
        Route::post('progress-status', 'ProgressStatusController@store');
        Route::put('progress-status/{id}', 'ProgressStatusController@update');
        Route::delete('progress-status/{id}', 'ProgressStatusController@delete');
    });
});

Route::group(['prefix' => 'engineer-side'], function() {
    Route::post('login', 'LoginController@loginEngineer');
    
    Route::group(['middleware' => 'auth:engineer'], function() {
        Route::get('job', 'JobController@all');
        Route::get('job/done', 'JobController@allDone');
        Route::get('job/progress', 'JobController@allProgress');
        Route::get('job/{id}', 'JobController@show');
        Route::get('job/{id}/progress', 'JobController@showProgress');

        Route::get('progress-job/{id}', 'ProgressJobController@show');
        Route::put('progress-job/{id}/remark', 'ProgressJobController@updateStatusAndRemark');

        Route::get('progress-status', 'ProgressStatusController@all');
    });
});

Route::group(['prefix' => 'management-side'], function() {
    Route::post('login', 'LoginController@loginManagement');
    
    Route::group(['middleware' => ['auth:management']], function() {
        Route::get('job', 'JobController@all');
        Route::get('job/done', 'JobController@allDone');
        Route::get('job/progress', 'JobController@allProgress');
        Route::get('job/{id}', 'JobController@show');
        Route::get('job/{id}/progress', 'JobController@showProgress');

        Route::get('progress-job/{id}', 'ProgressJobController@show');
        Route::put('progress-job/{id}/note', 'ProgressJobController@updateNote');
    });
});