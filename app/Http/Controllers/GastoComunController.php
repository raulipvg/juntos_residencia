<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\GastoComun;
use App\Models\GastoMe;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class GastoComunController extends Controller
{
    public function VerGastosComunes(Request $request){
        //FALTA SEGUN USER
        $comunidadId= 12;
        //setlocale(LC_TIME, 'es_ES.utf8');
        //Para colocar el nombre del mes en español 
        setlocale(LC_ALL, 'es');
        //TODAS LAS COMUNIDADES HABILITADAS
        $comunidades = Comunidad::select('Id','Nombre')
                                    ->where('Enabled', 1)
                                    ->orderBy('Nombre','asc')
                                    ->get();
        //ULTIMO GASTO MES PARA UNA COMUNIDAD DETERMINADA
        $gasto =  GastoMe::select('Id','TotalMes','FondoReserva','Total','Fecha')
                        ->where('ComunidadId', $comunidadId)
                        ->where('EstadoId', 2)
                        ->latest('Fecha')
                        ->first();

        //GASTOS MENSUALES DE TODOS LOS PROPIETARIOS SEGUN UN GASTO DE MES DETERMINADO               
        $gastosComunes = GastoComun::select('GastoComun.CobroGC','GastoComun.FondoReserva',
                                    'GastoComun.TotalGC','GastoComun.SaldoMesAnterior',
                                    'GastoComun.TotalCobroMes','Propiedad.Numero',
                                    'Propiedad.Prorrateo','Propiedad.Id',
                                    'Persona.Nombre','Persona.Apellido')
                            ->where('GastoComun.GastoMesId', $gasto->Id)
                            ->join('Propiedad','Propiedad.Id','=','GastoComun.PropiedadId')
                            ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                            ->where('Compone.Enabled', 1)
                            ->where('Compone.RolComponeCoReId', 1)
                            ->join('Persona','Persona.Id','=','Compone.PersonaId')
                            ->get();

        //TODOS LOS GASTOS MES PARA UNA COMUNIDAD SELECT2
        $gastosMeses = GastoMe::select('Id','Fecha')
                            ->where('ComunidadId', $comunidadId)
                            //->where('EstadoId', 2)
                            ->latest('Fecha')
                            ->get();

        return view('gastocomun.gastocomun')->with([
            'comunidades'=> $comunidades,
            'comunidadId'=> $comunidadId, 
            'gasto'=> $gasto,
            'gastoscomunes' => $gastosComunes,
            'gastosmeses'=> $gastosMeses,
        ]);
    }
}
