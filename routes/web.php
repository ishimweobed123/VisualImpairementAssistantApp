<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Device Management Routes
    Route::resource('devices', DeviceController::class);
    
    // Location Routes
    Route::get('/devices/{device}/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::post('/devices/{device}/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/devices/{device}/locations/latest', [LocationController::class, 'latest'])->name('locations.latest');
    Route::get('/devices/{device}/locations/history', [LocationController::class, 'history'])->name('locations.history');
    Route::get('/devices/{device}/locations/export', [LocationController::class, 'export'])->name('locations.export');
});

require __DIR__.'/auth.php';
