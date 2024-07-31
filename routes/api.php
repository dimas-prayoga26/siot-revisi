<?php

use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::prefix('auth')->group(function () {
    Route::post('/login',  'App\Http\Controllers\Api\AuthController@login');
    Route::post('/reset-password', 'App\Http\Controllers\Api\AuthController@resetPassword');
    Route::post('/refresh', 'App\Http\Controllers\Api\AuthController@refresh');
    Route::middleware(['auth:api'])->group(function(){
        Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
        Route::get('/user-profile', 'App\Http\Controllers\Api\AuthController@userProfile');
    });
});


Route::middleware(['auth:api'])->group(function () {
    //home
    Route::group(['prefix' => 'petugas'], function () {
        Route::get('/home', 'App\Http\Controllers\Api\HomeController@index');
    });

    //Schedule
    Route::get('/schedule/{user_id}', 'App\Http\Controllers\Api\ScheduleController@getByUserId');
    Route::apiResource('schedule', 'App\Http\Controllers\Api\ScheduleController');
    
    //TrashBin
    Route::get('/trashbins', 'App\Http\Controllers\Api\TrashBinController@index');
    Route::put('/trashbin/update-status/{uniqueId}', 'App\Http\Controllers\Api\TrashBinController@updateStatus');
    Route::put('/trashbin/update-picking-status/{id}/{status}', 'App\Http\Controllers\Api\TrashBinController@updatePickingStatus');
    
    //profile
    Route::put('/profile-update', 'App\Http\Controllers\Api\ProfileController@update');
    Route::put('/account-settings/{id}', 'App\Http\Controllers\Api\ProfileController@accountSetting');
    Route::put('/change-password', 'App\Http\Controllers\Api\ProfileController@updatePassword');
    
    //hittory
    Route::get('/histories/{id}', 'App\Http\Controllers\Api\HistoryController@index');

    //notifications
    Route::get('/notifications/{id}', 'App\Http\Controllers\Api\NotificationController@index');
    Route::get('/notifications/{id}/is-readed', 'App\Http\Controllers\Api\NotificationController@updateIsReaded');
    Route::get('/push-notif', 'App\Http\Controllers\Api\NotificationController@sendPushNotification');

    //expenses
    Route::post('/expense', 'App\Http\Controllers\Api\ExpenseController@store');

    //report
    Route::get('/report-data', 'App\Http\Controllers\Api\ReportController@reportData');
    Route::get('/report-data/excel', 'App\Http\Controllers\Api\ReportController@exportExcel');
    
    //officer
    Route::get('/user/home', 'App\Http\Controllers\Api\UserController@index');
    
    //complaints
    Route::get('/complaints', 'App\Http\Controllers\Api\ComplaintController@index');
    Route::post('/complaint', 'App\Http\Controllers\Api\ComplaintController@create');
    Route::post('/complaint-response', 'App\Http\Controllers\Api\ComplaintController@handleComplaint');


});

// Alat IOT Trash Bin

// Route::middleware(['iot_trash_bin'])->group(function () {
//     Route::post('/trash-data/create/{trashType}/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@create');
//     Route::put('/trashbin/update-trashbins/{uniqueId}', 'App\Http\Controllers\Api\TrashBinController@updateStatus');
// });

// // Alat IOT Trash Bin Counter

// Route::middleware(['weight_scale'])->group(function () {
//     Route::post('/trash-data/create/{trashType}/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@create');
// });

Route::middleware('check.unique.id')->group(function () {
    Route::post('/trash-data/create/{trashType}/{detailType?}/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@createByDetailType');
    Route::post('/trash-data/create/{trashType}/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@createByDetailType');
    Route::get('/device-info/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@getDeviceInfo');
});
Route::post('/change-pin/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@changePin');
Route::post('/reset-pin/{uniqueId}', 'App\Http\Controllers\Api\TrashDataController@resetPin');


Route::put('/trashbin/update-trashbins/{uniqueId}', 'App\Http\Controllers\Api\TrashBinController@updateStatus')->middleware('iot_trash_bin');
