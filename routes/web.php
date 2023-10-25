<?php

use App\Http\Controllers\ComponeController;
use App\Http\Controllers\AccesoComunidadController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\HojaVidaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PropiedadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CopropietarioController;
use App\Http\Controllers\EspacioComunController;
use App\Http\Controllers\ResidenteController;
use App\Http\Controllers\TipoCobro;
use App\Models\AccesoComunidad;
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

Route::group(['prefix' => '/acceso'], function () {
    //Route::get('/', [UserController::class, 'Index'])->name('Usuario');
    Route::post('/registrar', [AccesoComunidadController::class, 'Guardar'])->name('RegistrarAcceso');
    Route::post('/ver', [AccesoComunidadController::class, 'VerId'])->name('VerAcceso');
    Route::post('/editar', [AccesoComunidadController::class, 'Editar'])->name('EditarAcceso');
});

Route::group(['prefix' => '/comunidad'], function () {
    Route::get('/', [ComunidadController::class, 'Index'])->name('Comunidad');
    Route::post('/registrar', [ComunidadController::class, 'Guardar'])->name('GuardarComunidad');
    Route::post('/ver', [ComunidadController::class, 'VerId'])->name('VerComunidad');
    Route::post('/editar', [ComunidadController::class, 'Editar'])->name('EditarComunidad');
});
Route::group(['prefix' => '/propiedad'], function () {
    Route::get('/', [PropiedadController::class, 'Index'])->name('Propiedad');
    Route::post('/registrar', [PropiedadController::class, 'Guardar'])->name('GuardarPropiedad');
    Route::post('/ver', [PropiedadController::class, 'VerId'])->name('VerPropiedad');
    Route::post('/editar', [PropiedadController::class, 'Editar'])->name('EditarPropiedad');
});

Route::group(['prefix' => '/espaciocomun'], function () {
    Route::post('/listar', [EspacioComunController::class, 'Index'])->name('EspacioComun');
    Route::post('/registrar', [EspacioComunController::class, 'Guardar'])->name('GuardarEspacioComun');
    Route::post('/ver', [EspacioComunController::class, 'VerId'])->name('VerEspacioComun');
    Route::post('/editar', [EspacioComunController::class, 'Editar'])->name('EditarEspacioComun');
});


Route::group(['prefix' => '/residente'], function () {
    Route::get('/', [ComponeController::class, 'Index'])->name('Residente');
    Route::post('/registrar', [ComponeController::class, 'Guardar'])->name('GuardarResidente');
    Route::post('/ver', [ComponeController::class, 'VerId'])->name('VerResidente');
    Route::post('/editar', [ComponeController::class, 'Editar'])->name('EditarResidente');
    Route::post('/registrar-persona', [PersonaController::class, 'Guardar'])->name('GuardarPersona');
    Route::post('/ver-persona', [PersonaController::class, 'VerId'])->name('VerPersona');
    Route::post('/editar-persona', [PersonaController::class, 'Editar'])->name('EditarPersona');
});

Route::group(['prefix' => '/hojavida'], function () {
    Route::post('/listar', [HojaVidaController::class, 'Index'])->name('HojaVida');
    Route::post('/registrar', [HojaVidaController::class, 'Guardar'])->name('GuardarHojaVida');
    Route::post('/ver', [HojaVidaController::class, 'VerId'])->name('VerHojaVida');
    Route::post('/editar', [HojaVidaController::class, 'Editar'])->name('EditarHojaVida');
});

Route::group(['prefix' => '/compone'], function () {
    Route::post('/registrar', [ComponeController::class, 'Guardar'])->name('GuardarCompone');
    Route::post('/ver', [ComponeController::class, 'VerId'])->name('VerCompone');
    Route::post('/editar', [ComponeController::class, 'Editar'])->name('EditarCompone');
});



