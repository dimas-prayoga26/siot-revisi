<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\DuesesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TrashBinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrashDataController;
use App\Http\Controllers\TrashTypeController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserPetugasController;
use App\Http\Controllers\WeightScaleController;
use App\Http\Controllers\MetaDataDateController;
use App\Http\Controllers\UserMasyarakatController;
use App\Http\Controllers\MetaDuesNominalController;
use App\Http\Controllers\TrashBinCounterController;
use App\Http\Controllers\TrashDataAllController;
use App\Http\Controllers\TrashDataByTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/forgot-password', function (){
    return view('auth.forgot-password');
})->name('forgot-password');

Route::post('/forgot-password', [AuthController::class, 'mailSend'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset')->middleware('check.reset.token');
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('CheckResettingPassword');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('CheckResettingPassword');
Route::get('/email', function (){
    return view('email.email');
})->name('reset-password');

Route::view('/error/page-400', 'error.400')->name('error.page.400');

Route::view('/error/page-401', 'error.401')->name('error.page.401');

Route::view('/error/page-403', 'error.403')->name('error.page.403');

Route::view('/error/page-404', 'error.404')->name('error.page.404');

Route::view('/error/page-500', 'error.500')->name('error.page.500');

Route::view('/error/page-503', 'error.503')->name('error.page.503');





Route::controller(AuthController::class)->group(function () {

    Route::get('/', function (){
        return view('auth.login');
    })->name('login');
    // Route::view('/',     'login')->name('login');
    Route::post('/login-process', 'login')->name('procces.login');
    Route::get('/logout', 'logout')->name('logout');

});



Route::middleware(['web', 'auth', 'check.session'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/datas', [DashboardController::class, 'fetchData'])->name('dashboard.fetchData');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chartData');
    Route::get('/dashboard/export/trash-excel', [DashboardController::class, 'exportExcel']);
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/dashboard/profile/{profile}/detail', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::put('/dashboard/profile/{profile}', [ProfileController::class, 'update'])->name('update.profile');
    
    Route::get('/google-maps', [MapsController::class, 'index'])->name('mapsIot');
    Route::get('/google-maps/data', [MapsController::class, 'getMapData'])->name('mapsIot.data');

    Route::group(['prefix' => 'data_akun'], function() {
        Route::get('admin/datatable', [UserAdminController::class, 'datatable'])->name('admin.datatable');
        Route::resource('admin', UserAdminController::class);
    });

    Route::group(['prefix' => 'data_akun'], function() {
        Route::get('petugas/datatable', [UserPetugasController::class, 'datatable'])->name('petugas.datatable');
    Route::resource('petugas', UserPetugasController::class);
    });

    Route::group(['prefix' => 'data_akun'], function() {
        Route::get('masyarakat/datatable', [UserMasyarakatController::class, 'datatable'])->name('masyarakat.datatable');
        Route::resource('masyarakat', UserMasyarakatController::class);
    });

    Route::group(['prefix' => 'data'], function() {
        Route::get('trash-bin/datatable', [TrashBinController::class, 'datatable'])->name('trash-bin.datatable');
        Route::post('trash-bin/isActive', [TrashBinController::class, 'isActive'])->name('trash-bin.isActive');
        Route::resource('trash-bin', TrashBinController::class);
    });

    Route::group(['prefix' => 'data'], function() {
        Route::get('weight-scale/datatable', [WeightScaleController::class, 'datatable'])->name('weight-scale.datatable');
        Route::post('weight-scale/isActive', [WeightScaleController::class, 'isActive'])->name('weight-scale.isActive');
        Route::resource('weight-scale', WeightScaleController::class);
    });

    Route::group(['prefix' => 'management'], function() {
        Route::get('trash-data-all/datatable', [TrashDataAllController::class, 'datatable'])->name('trash-data-all.datatable');
        Route::get('trash-data-all/check-new-data', [TrashDataAllController::class, 'checkNewData'])->name('check-new-data-trash-data-all');
        Route::get('trash-data-all/history', [TrashDataAllController::class, 'showHistory'])->name('trash-data-all.history');
        Route::resource('trash-data-all', TrashDataAllController::class);
    });
    
    Route::group(['prefix' => 'management'], function() {
        Route::get('trash-data-by-type/datatable', [TrashDataByTypeController::class, 'datatable'])->name('trash-data-by-type.datatable');
        Route::get('trash-data-by-type/check-new-data', [TrashDataByTypeController::class, 'checkNewData'])->name('check-new-data-trash-data-by-type');
        Route::get('trash-data-by-type/history', [TrashDataByTypeController::class, 'showHistory'])->name('trash-data-by-type.history');
        Route::resource('trash-data-by-type', TrashDataByTypeController::class);
    });

    Route::get('trash-type/datatable', [TrashTypeController::class, 'datatable'])->name('trash-type.datatable');
    Route::resource('trash-type', TrashTypeController::class);

    Route::get('dueses/datatable', [DuesesController::class, 'datatable'])->name('dueses.datatable');
    Route::get('dueses/export/tagihan', [DuesesController::class, 'exportExcel'])->name('dueses.export');
    Route::post('dueses/notification', [DuesesController::class, 'notification'])->name('dueses.notification');
    Route::post('dueses/update-status', [DuesesController::class, 'updateStatus'])->name('dueses.updateStatus');
    Route::resource('dueses', DuesesController::class);

    Route::get('expenses/datatable', [ExpenseController::class, 'datatable'])->name('expenses.datatable');
    Route::resource('expenses', ExpenseController::class);

    Route::get('meta-dueses-nominal/datatable', [MetaDuesNominalController::class, 'datatable'])->name('meta-dueses-nominal.datatable');
    Route::resource('meta-dueses-nominal', MetaDuesNominalController::class);

    Route::get('feedback/datatable', [FeedbackController::class, 'datatable'])->name('feedback.datatable');
    Route::post('feedback/toHold', [FeedbackController::class, 'needsValidation'])->name('feedback.needsValidation');
    Route::post('feedback/toSolved', [FeedbackController::class, 'onHold'])->name('feedback.onHold');
    Route::resource('feedback', FeedbackController::class);

    Route::get('pengaturan-tanggal-mingguan/datatable', [MetaDataDateController::class, 'datatable'])->name('pengaturan-tanggal-mingguan.datatable');
    Route::resource('pengaturan-tanggal-mingguan', MetaDataDateController::class);
    
    Route::get('schedule/datatable', [ScheduleController::class, 'datatable'])->name('schedule.datatable');
    Route::post('schedule/isActive', [ScheduleController::class, 'isActive'])->name('schedule.isActive');
    Route::resource('schedule', ScheduleController::class);

});
