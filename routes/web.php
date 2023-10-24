<?php

use App\Http\Controllers\ComponeController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\PropiedadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CopropietarioController;
use App\Http\Controllers\EspacioComunController;
use App\Http\Controllers\ResidenteController;
use App\Http\Controllers\TipoCobro;
use App\Models\EspacioComun;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::get('/', [HomeController::class, 'Index'])->name('Home');
});


Route::group(['prefix' => '/usuario'], function () {
    Route::get('/', [UserController::class, 'Index'])->name('Usuario');
    Route::post('/registrar', [UserController::class, 'Guardar'])->name('GuardarUsuario');
    Route::post('/ver', [UserController::class, 'VerId'])->name('VerUsuario');
    Route::post('/editar', [UserController::class, 'Editar'])->name('EditarUsuario');
});


Route::group(['prefix' => '/comunidad'], function () {
    Route::get('/', [ComunidadController::class, 'Index'])->name('Comunidad');
    Route::post('/registrar', [ComunidadController::class, 'Guardar'])->name('GuardarComunidad');
    Route::post('/ver', [ComunidadController::class, 'VerId'])->name('VerComunidad');
    Route::post('/editar', [ComunidadController::class, 'Editar'])->name('EditarComunidad');
});

Route::group(['prefix' => '/espaciocomun'], function () {
    Route::post('/listar', [EspacioComunController::class, 'Index'])->name('EspacioComun');
    Route::post('/registrar', [EspacioComunController::class, 'Guardar'])->name('GuardarEspacioComun');
    Route::post('/ver', [EspacioComunController::class, 'VerId'])->name('VerEspacioComun');
    Route::post('/editar', [EspacioComunController::class, 'Editar'])->name('EditarEspacioComun');
});


Route::group(['prefix' => '/propiedad'], function () {
    Route::get('/', [PropiedadController::class, 'Index'])->name('Propiedad');
    Route::post('/registrar', [PropiedadController::class, 'Guardar'])->name('GuardarPropiedad');
    Route::post('/ver', [PropiedadController::class, 'VerId'])->name('VerPropiedad');
    Route::post('/editar', [PropiedadController::class, 'Editar'])->name('EditarPropiedad');
});

Route::group(['prefix' => '/residente'], function () {
    Route::get('/', [ComponeController::class, 'Index'])->name('Residente');
    Route::post('/registrar', [ComponeController::class, 'Guardar'])->name('GuardarResidente');
    Route::post('/ver', [ComponeController::class, 'VerId'])->name('VerResidente');
    Route::post('/editar', [ComponeController::class, 'Editar'])->name('EditarResidente');
});


