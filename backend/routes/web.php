<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RadioTaxiAdminController;
use App\Http\Controllers\Admin\RutaAdminController;
use App\Http\Controllers\Admin\SindicatoAdminController;
use App\Http\Controllers\Admin\TrufiAdminController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // TRUFIS (CRUD)
        Route::get('/trufis', [TrufiAdminController::class, 'listarTrufis'])
            ->middleware('permission:admin.trufis.ver')
            ->name('trufis.index');
        Route::get('/trufis/crear', [TrufiAdminController::class, 'mostrarCrear'])
            ->middleware('permission:admin.trufis.crear')
            ->name('trufis.crear');
        Route::post('/trufis', [TrufiAdminController::class, 'guardarTrufi'])
            ->middleware('permission:admin.trufis.crear')
            ->name('trufis.guardar');
        Route::get('/trufis/{id}/editar', [TrufiAdminController::class, 'mostrarEditar'])
            ->middleware('permission:admin.trufis.editar')
            ->name('trufis.editar');
        Route::put('/trufis/{id}', [TrufiAdminController::class, 'actualizarTrufi'])
            ->middleware('permission:admin.trufis.editar')
            ->name('trufis.actualizar');
        Route::delete('/trufis/{id}', [TrufiAdminController::class, 'eliminarTrufi'])
            ->middleware('permission:admin.trufis.eliminar')
            ->name('trufis.eliminar');

        // RUTAS (CRUD)
        Route::get('/rutas', [RutaAdminController::class, 'listarRutas'])
            ->middleware('permission:admin.rutas.ver')
            ->name('rutas.index');
        Route::get('/rutas/crear', [RutaAdminController::class, 'mostrarCrearRuta'])
            ->middleware('permission:admin.rutas.crear')
            ->name('rutas.crear');
        Route::post('/rutas', [RutaAdminController::class, 'guardarRuta'])
            ->middleware('permission:admin.rutas.crear')
            ->name('rutas.guardar');
        Route::get('/rutas/{idtrufi}/editar', [RutaAdminController::class, 'mostrarEditarRuta'])
            ->middleware('permission:admin.rutas.editar')
            ->name('rutas.editar');
        Route::put('/rutas/{idtrufi}', [RutaAdminController::class, 'actualizarRuta'])
            ->middleware('permission:admin.rutas.editar')
            ->name('rutas.actualizar');
        Route::get('/rutas/{idtrufi}/ubicaciones', [RutaAdminController::class, 'verUbicaciones'])
            ->middleware('permission:admin.rutas.ver')
            ->name('rutas.ver_ubicaciones');
        Route::delete('/rutas/{idtrufi}', [RutaAdminController::class, 'eliminarRuta'])
            ->middleware('permission:admin.rutas.eliminar')
            ->name('rutas.eliminar');

        // SINDICATOS (CRUD)
        Route::get('/sindicatos', [SindicatoAdminController::class, 'index'])
            ->middleware('permission:admin.sindicatos.ver')
            ->name('sindicatos.index');
        Route::get('/sindicatos/crear', [SindicatoAdminController::class, 'create'])
            ->middleware('permission:admin.sindicatos.crear')
            ->name('sindicatos.crear');
        Route::post('/sindicatos', [SindicatoAdminController::class, 'store'])
            ->middleware('permission:admin.sindicatos.crear')
            ->name('sindicatos.guardar');
        Route::get('/sindicatos/{id}/editar', [SindicatoAdminController::class, 'edit'])
            ->middleware('permission:admin.sindicatos.editar')
            ->name('sindicatos.editar');
        Route::put('/sindicatos/{id}', [SindicatoAdminController::class, 'update'])
            ->middleware('permission:admin.sindicatos.editar')
            ->name('sindicatos.actualizar');
        Route::delete('/sindicatos/{id}', [SindicatoAdminController::class, 'destroy'])
            ->middleware('permission:admin.sindicatos.eliminar')
            ->name('sindicatos.eliminar');

        // RADIOTAXIS + PARADAS (CRUD)
        Route::get('/radiotaxis', [RadioTaxiAdminController::class, 'index'])
            ->middleware('permission:admin.radiotaxis.ver')
            ->name('radiotaxis.index');
        Route::get('/radiotaxis/crear', [RadioTaxiAdminController::class, 'create'])
            ->middleware('permission:admin.radiotaxis.crear')
            ->name('radiotaxis.crear');
        Route::post('/radiotaxis', [RadioTaxiAdminController::class, 'store'])
            ->middleware('permission:admin.radiotaxis.crear')
            ->name('radiotaxis.guardar');
        Route::get('/radiotaxis/{id}/editar', [RadioTaxiAdminController::class, 'edit'])
            ->middleware('permission:admin.radiotaxis.editar')
            ->name('radiotaxis.editar');
        Route::put('/radiotaxis/{id}', [RadioTaxiAdminController::class, 'update'])
            ->middleware('permission:admin.radiotaxis.editar')
            ->name('radiotaxis.actualizar');
        Route::delete('/radiotaxis/{id}', [RadioTaxiAdminController::class, 'destroy'])
            ->middleware('permission:admin.radiotaxis.eliminar')
            ->name('radiotaxis.eliminar');
    });
});
