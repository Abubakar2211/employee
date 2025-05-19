<?php

use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::post('login', [EmployeeAuthController::class, 'login'])->name('login_post');

Route::middleware(['checkEmployee'])->group(function () {
    Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('employee', EmployeeController::class);
    Route::resource('payment', PaymentController::class);
    Route::get('/get-employees-by-status', [EmployeeController::class, 'getEmployeesByStatus']);
    Route::get('/get-payments-by-status', [PaymentController::class, 'getPaymentsByStatus']);
    Route::get('/filter-payments', [PaymentController::class, 'filterPayments']);
    Route::get('/filter-employees', [EmployeeController::class, 'filterEmployees']);
    Route::get('/payments/{id}',[PaymentController::class,'payments'])->name('payments');
});

Route::get('/clear-all-cache', [EmployeeController::class , 'clear_all_cache']);
Route::get('/clear-all-config', [EmployeeController::class , 'clear_all_config']);
Route::get('/clear-all-route', [EmployeeController::class , 'clear_all_route']);
Route::get('/clear-all-view', [EmployeeController::class , 'clear_all_view']);
Route::get('/truncate-migration', [EmployeeController::class , 'truncate_migration']);
