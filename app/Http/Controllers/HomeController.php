<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Propiedad;
use App\Models\GastoMe;
use App\Models\Compone;
use App\Models\HistorialPago;
use App\Models\GastosDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function Index(Request $request){
        if($request->input('c') != null && $request->input('g') != null){
            $comunidadId = $request->input('c');
            $gastoMesId = $request->input('g');
        }
        else{
            $comunidadId = 12;               //FALTA SEGUN USER
            //TODOS LOS GASTOS MES CERRADOS PARA UNA COMUNIDAD SELECT2
            $gastosMeses = GastoMe::select('Id','Fecha','FechaFin','EstadoId')
                                    ->where('ComunidadId', $comunidadId)
                                    //->where('EstadoId', 2)
                                    ->latest('Fecha')
                                    ->get();
            //$gastoMesId = $gastosMeses->first()->Id;
            $gastoMesId =17;
        }
        setlocale(LC_ALL, 'es');         
        //TODAS LAS COMUNIDADES HABILITADAS
        $comunidades = Comunidad::select('Id','Nombre')
                            ->where('Enabled', 1)
                            ->orderBy('Nombre','asc')
                            ->get();
        
        $propiedadesActivas = Propiedad::where('ComunidadId',$comunidadId)
                                        ->where('Enabled',1)
                                        ->count();

        // Restricción persona enabled?
        $propietarios = Compone::join('Propiedad','Compone.PropiedadId','Propiedad.Id')
                                    ->where('Propiedad.ComunidadId', $comunidadId)
                                    ->where('Compone.Enabled',1)
                                    ->where('Compone.RolComponeCoReId', 1)
                                    ->count();
        
        $arrendatarios = Compone::join('Propiedad','Compone.PropiedadId','Propiedad.Id')
                                    ->where('Propiedad.ComunidadId', $comunidadId)
                                    ->where('Compone.Enabled',1)
                                    ->where('Compone.RolComponeCoReId', 2)
                                    ->count();

        $fechaActual = GastoMe::select('Fecha')
                                ->where('Id', $gastoMesId)
                                ->first();
        
        $ingresos = HistorialPago::join('GastoComun','GastoComun.Id', '=', 'HistorialPago.GastoComunId')
                                    ->join('GastoMes','GastoMes.Id', '=', 'GastoComun.GastoMesId')
                                    ->where('GastoMes.ComunidadId',$comunidadId)
                                    ->whereYear('HistorialPago.FechaPago',$fechaActual->Fecha)
                                    ->whereMonth('HistorialPago.FechaPago',$fechaActual->Fecha)
                                    ->sum('MontoPagado');
        
        $egresos = GastoMe::select('TotalMes')
                            ->where('GastoMes.Id',$gastoMesId)
                            ->first();
        $egresos = $egresos['TotalMes'];

        $egresosTipoGasto = GastosDetalle::select(DB::raw('SUM("GastosDetalle"."Precio") as Total'), 'TipoGasto.Nombre')
                                        ->join('TipoGasto', 'GastosDetalle.TipoGastoId', '=', 'TipoGasto.Id')
                                        ->where('GastosDetalle.GastoMesId', $gastoMesId)
                                        ->groupBy('TipoGasto.Nombre')
                                        ->get();

        $cobranzasMes = HistorialPago::select(DB::raw('SUM("HistorialPago"."MontoPagado") as Total'), 'EstadoPago.Nombre as Estado')
                                    ->join('EstadoPago', 'HistorialPago.EstadoPagoId', 'EstadoPago.Id')
                                    ->join('GastoComun', 'GastoComun.Id', '=', 'HistorialPago.GastoComunId')
                                    ->join('GastoMes', 'GastoMes.Id', '=', 'GastoComun.GastoMesId')
                                    ->leftJoin(DB::raw('(SELECT "GastoComunId", MAX("FechaPago") as "MaxFechaPago" FROM "HistorialPago" GROUP BY "GastoComunId") "hp"'), function ($join) {
                                        $join->on('GastoComun.Id', '=', 'hp.GastoComunId');
                                    })
                                    ->where('GastoMes.ComunidadId', $comunidadId)
                                    ->whereYear('hp.MaxFechaPago', $fechaActual->Fecha)
                                    ->whereMonth('hp.MaxFechaPago', $fechaActual->Fecha)
                                    ->groupBy('EstadoPago.Nombre')
                                    ->get();



        
        return View('home.home')->with([
            'comunidades'=> $comunidades,
            'comunidadId'=> $comunidadId,
            'propiedadesActivas' => $propiedadesActivas,
            'propietarios' => $propietarios,
            'arrendatarios' => $arrendatarios,
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'egresosTipoGasto' => $egresosTipoGasto,
            'cobranzaMes' => $cobranzasMes,
            'gastosmeses'=> $gastosMeses,
            'gasto' => $gastoMesId,
            'fecha'=> $fechaActual,
        ]);
    }
}
