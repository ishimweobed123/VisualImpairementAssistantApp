<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;

Route::post('/device/auth', [DeviceController::class, 'authenticate']);