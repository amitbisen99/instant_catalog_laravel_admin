<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('users', [App\Http\Controllers\DashboardController::class, 'Users'])->name('users');
    Route::post('users/delete/{id}', [App\Http\Controllers\DashboardController::class, 'Delete'])->name('user.delete');
    Route::post('users/status/change/{id}', [App\Http\Controllers\DashboardController::class, 'StatusChange'])->name('user.status-change');
});
