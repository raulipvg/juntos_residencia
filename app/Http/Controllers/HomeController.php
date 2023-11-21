<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\GastoMe;
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
        
        //TODOS LOS GASTOS MES PARA UNA COMUNIDAD SELECT2
        $gastosMeses = GastoMe::select('Id','Fecha','EstadoId')
                            ->where('ComunidadId', $comunidadId)
                            ->latest('Fecha')
                            ->get();
        //EL GASTO DE MES PARA UNA COMUNIDAD Y FECHA ESTABLECIDA
        $gasto =  GastoMe::select('Id')
                        ->where('ComunidadId', $comunidadId)
                        ->latest('Fecha')
                        ->first();

        return View('home.home')->with([
            'comunidades'=> $comunidades,
            'comunidadId'=> $comunidadId,
            'gastosmeses'=> $gastosMeses,
            'gasto'=> $gasto
        ]);
    }
}
