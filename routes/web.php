<?php

use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::post('login', [EmployeeAuthController::class, 'login'])->name('login_post');

Route::middleware(['checkEmployee'])->group(function () {
    Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('logout');
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('employee', EmployeeController::class);
    Route::resource('payment', PaymentController::class);
    Route::get('/get-employees-by-status', [EmployeeController::class, 'getEmployeesByStatus']);
    Route::get('/get-payments-by-status', [PaymentController::class, 'getPaymentsByStatus']);
    Route::get('/filter-payments', [PaymentController::class, 'filterPayments']);
    Route::get('/payments/{id}',[PaymentController::class,'payments'])->name('payments');
});
