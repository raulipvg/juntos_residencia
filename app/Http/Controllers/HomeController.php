<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function Index(){
        //FALTA SEGUN USER
        $comunidadId= 12;
        //TODAS LAS COMUNIDADES HABILITADAS
        $comunidades = Comunidad::select('Id','Nombre')
                            ->where('Enabled', 1)
                            ->orderBy('Nombre','asc')
                            ->get();
        return View('home.home')->with([
            'comunidades'=> $comunidades,
            'comunidadId'=> $comunidadId
        ]);
    }
}
