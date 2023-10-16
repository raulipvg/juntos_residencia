<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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


Route::get('/usuario', [UserController::class, 'index'])->name('usuarios');

Route::post('/usuario/registrar', [UserController::class, 'Save'])->name('GuardarUsuario');
Route::post('/usuario/ver', [UserController::class, 'VerId'])->name('VerUsuario');
Route::post('/usuario/editar', [UserController::class, 'Editar'])->name('EditarUsuario');




Route::get('/', function () {
    return view('welcome');
});
