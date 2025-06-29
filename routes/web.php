<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MacAddressController;
use App\Http\Controllers\StatusAccessPointController;


// Login
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/failed', function () {
    return view('failed');
});


// Auth Login & Logout
Route::get('login', [AuthController::class, 'index'])->name('auth.index');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard real time
Route::get('dashboard/{traffic}', [DashboardController::class, 'traffic'])->name('dashboard.traffic');

Route::get('dashboard/test-traffic/{interface}', [DashboardController::class, 'testTraffic'])->name('dashboard.testTraffic');


// Mac address
Route::get('macaddress', [MacAddressController::class, 'index'])->name('macaddress.mac');
Route::get('macaddress/delete/{id}', [MacAddressController::class, 'delete'])->name('macaddress.delete');

// Status
Route::get('status', [StatusAccessPointController::class, 'index'])->name('statusap.status');


// Report
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/json', [ReportController::class, 'json'])->name('report.json');
Route::get('/report/store-traffic', [ReportController::class, 'storeTraffic'])->name('report.store');