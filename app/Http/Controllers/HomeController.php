<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\EstadoUsuario;

class HomeController extends Controller
{
    public function users(){
        $usuarios = Usuario::all();
        return View('home.usuarios')->with([
            'Usuarios' => $usuarios
        ]);
    }
}
