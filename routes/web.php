<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportStatusController;
use App\Http\Controllers\Admin\ReportCategoryController;
use App\Http\Controllers\User\ReportController as UserReportController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/reports', [UserReportController::class, 'index'])->name('report.index');
Route::get('/report/{code}', [UserReportController::class, 'show'])->name('report.show');

Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login', [LoginController::class, 'store'])->name('auth.login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::prefix('admin')->name('admin.')->middleware('auth', 'role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/residents', ResidentController::class);
    Route::resource('/report-categories', ReportCategoryController::class);
    Route::resource('/reports', ReportController::class);
    Route::resource('/report-statuses', ReportStatusController::class);
});
