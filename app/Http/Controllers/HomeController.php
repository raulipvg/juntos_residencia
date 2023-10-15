<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class HomeController extends Controller
{
    public function users(){
        $usuarios = Usuario::all();
        return View('home.usuarios')->with([
            'Usuario' => $usuarios
        ]);
    }
}
