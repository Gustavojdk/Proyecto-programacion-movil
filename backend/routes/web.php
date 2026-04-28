<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/api/test', function () {
    return response()->json([
        "status" => "ok",
        "mensaje" => "API funcionando correctamente",
    ]);
});

Route::get('/api/trufis', function () {
    return response()->json([
        [
            "id" => 1,
            "nombre" => "Trufi 1",
            "ruta" => "Centro - Norte"
        ],
        [
            "id" => 2,
            "nombre" => "Trufi 2",
            "ruta" => "Sur - Norte"
        ]
    ]);
});

Route::get('/api/radio-taxis', function () {
    return response()->json([
        [
            "id" => 1,
            "nombre" => "Radio Taxi Express",
            "telefono" => "12345678"
        ],
        [
            "id" => 2,
            "nombre" => "Radio Taxi Seguro",
            "telefono" => "87654321"
        ]
    ]);
});