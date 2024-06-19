<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistorialMedicoController;
use App\Http\Controllers\DashboardController;





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/usuarios', function () {
        return view('usuarios');
    })->name('usuarios');

    Route::get('/citas', function () {
        return view('citas');
    })->name('citas');

    Route::get('/historialmedico', function () {
        return view('historialmedico');
    })->name('historialmedico');


    Route::get('/calendario', function () {
        return view('calendario');
    })->name('calendario');

    Route::get('/facturas', function () {
        return view('facturas');
    })->name('facturas');
});


Route::get('/citascalendario', [CitaController::class, 'getCitasForCalendar'])->name('citascalendario');


Route::get('/grafico1', [DashboardController::class, 'index'])->name('grafico1');
Route::get('/grafico2', [DashboardController::class, 'index2'])->name('grafico2');
Route::get('/grafico3', [DashboardController::class, 'index3'])->name('grafico3');
Route::get('/grafico4', [DashboardController::class, 'index4'])->name('grafico4');

#crud usuario
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/usuarios/crear', [UserController::class, 'crearUser'])->name('usuarios.crear');
Route::put('/usuarios/actualizar/{id}', [UserController::class, 'actualizarUser'])->name('usuarios.actualizar');
Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'eliminarUser'])->name('usuarios.eliminar');

#crud para citas
Route::get('/doctores', [UserController::class, 'doctores'])->name('doctores');
Route::get('/citas', [UserController::class, 'logeado'])->name('logeado');
Route::get('/obtenercitas', [CitaController::class, 'index'])->name('obtenercitas');
Route::post('/crearcita', [CitaController::class, 'crearCita'])->name('crear.cita');
Route::get('/citas/{id}', [CitaController::class, 'mostrarCita'])->name('mostrar.citas');
Route::put('/citas/actualizar/{id}', [CitaController::class, 'editarCita'])->name('citas.actualizar');
Route::delete('/citas/eliminar/{id}', [CitaController::class, 'eliminarCita'])->name('citas.eliminar');


#crud para historialmedico
Route::get('/pacientes', [UserController::class, 'pacientes'])->name('pacientes');
Route::get('/historiales', [HistorialMedicoController::class, 'getHistoriales'])->name('historiales');
Route::post('/crearHistorial', [HistorialMedicoController::class, 'crearhistorial'])->name('crear.historial');
Route::put('/historial/actualizar/{id}', [HistorialMedicoController::class, 'editarHistorial'])->name('historial.actualizar');
Route::get('/historiales/{id}', [HistorialMedicoController::class, 'mostrarHistorial'])->name('mostrar.historial');
Route::delete('/historial/eliminar/{id}', [HistorialMedicoController::class, 'eliminarHistorial'])->name('historial.eliminar');
