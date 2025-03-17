<?php

use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login'); 
Route::post('login', [EmployeeAuthController::class, 'login'])->name('login_post');

Route::middleware(['checkEmployee'])->group(function () {
    Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('logout');
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('employee', EmployeeController::class);
});
