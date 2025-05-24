<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DangerZoneController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/devices', [DeviceController::class, 'index'])->name('user.devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])->name('user.devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])->name('user.devices.store');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('user.devices.show');
    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('user.devices.edit');
    Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('user.devices.update');
    Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('user.devices.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('devices', AdminDeviceController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::resource('danger-zones', DangerZoneController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');
        Route::get('/reports/csv', [ReportController::class, 'downloadCsv'])->name('reports.csv');
    });
});