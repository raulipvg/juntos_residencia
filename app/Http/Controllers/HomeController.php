<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Propiedad;
use App\Models\GastoMe;
use App\Models\Compone;
use App\Models\HistorialPago;
use App\Models\GastosDetalle;
use App\Models\GastoComun;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function Index(Request $request){
        $comunidadId = $request->input('c');
        $gastoMesId = $request->input('g');
        if(isset($comunidadId)){
            $gastosMeses = GastoMe::select('Id','Fecha','FechaFin','EstadoId')
                                    ->where('ComunidadId', $comunidadId)
                                    //->where('EstadoId', 2)
                                    ->latest('Fecha')
                                    ->get();
            if(!isset($gastoMesId)){
                
                $gastoMesId = $gastosMeses->first()->Id;
            }
        }
        else{
            $comunidadId = 12;               //FALTA SEGUN USER
            //TODOS LOS GASTOS MES CERRADOS PARA UNA COMUNIDAD SELECT2
            $gastosMeses = GastoMe::select('Id','Fecha','FechaFin','EstadoId')
                                    ->where('ComunidadId', $comunidadId)
                                    //->where('EstadoId', 2)
                                    ->latest('Fecha')
                                    ->get();
            $gastoMesId = $gastosMeses->first()->Id;
            //$gastoMesId =17;
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
        /*  Ingresos registrados por pagos hechos en el mes actual (si paga en noviembre, se muestra como noviembre)
        $ingresos = HistorialPago::join('GastoComun','GastoComun.Id', '=', 'HistorialPago.GastoComunId')
                                    ->join('GastoMes','GastoMes.Id', '=', 'GastoComun.GastoMesId')
                                    ->where('GastoMes.ComunidadId',$comunidadId)
                                    ->whereYear('HistorialPago.FechaPago',$fechaActual->Fecha)
                                    ->whereMonth('HistorialPago.FechaPago',$fechaActual->Fecha)
                                    ->sum('MontoPagado');
        */

        // Ingresos para el mes GastoMesId (Pago del gasto común generado por ese mes, si paga en noviembre, se muestra como octubre)
        $ingresos = HistorialPago::join('GastoComun','GastoComun.Id', '=', 'HistorialPago.GastoComunId')
                                    ->where('GastoComun.GastoMesId', $gastoMesId)
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

        //
        $cobranzasMes = HistorialPago::select(DB::raw('COUNT("HistorialPago"."EstadoPagoId") as Total'), 'EstadoPago.Nombre as Estado')
                                                    ->join('EstadoPago', 'HistorialPago.EstadoPagoId', 'EstadoPago.Id')
                                                    ->join('GastoComun','HistorialPago.GastoComunId', '=','GastoComun.Id')
                                                    ->where('GastoComun.GastoMesId', $gastoMesId)
                                                    ->where(function ($query) {
                                                        $query->whereExists(function ($query) {
                                                            $query->select(DB::raw(1))
                                                                ->from('HistorialPago')
                                                                ->whereColumn('FechaPago', 'HistorialPago.FechaPago')
                                                                ->groupBy('GastoComunId');
                                                        })
                                                        ->orWhereNull('FechaPago');
                                                    })
                                                    ->groupBy('EstadoPago.Nombre')
                                                    ->get();

        //propiedades con dueño
        $propiedadesOcupadas = Compone::select('Compone.Id')
                                        ->join('Propiedad','Compone.PropiedadId','Propiedad.Id')
                                        ->where('Propiedad.ComunidadId',$comunidadId)
                                        ->where('RolComponeCoReId',1)
                                        ->where('Compone.Enabled',1)
                                        ->get();

        $fondoReserva = GastoMe::select('FondoReserva')
                                        ->where('GastoMes.Id',$gastoMesId)
                                        ->get();
        
        $morosidad = GastoComun::select('GastoComun.SaldoMesAnterior','Persona.Nombre','Persona.Apellido','Propiedad.Numero')
                                ->join('Propiedad','GastoComun.PropiedadId','=','Propiedad.Id')
                                ->join('Compone','Propiedad.Id','=','Compone.PropiedadId')
                                ->join('Persona','Persona.Id','=','Compone.PersonaId')
                                ->where('Compone.RolComponeCoReId',1)
                                ->where('Compone.Enabled',1)
                                ->where('GastoComun.GastoMesId', $gastoMesId)
                                ->where('GastoComun.SaldoMesAnterior','<>',0)
                                ->get();

        $evolucionIngresos = HistorialPago::select(DB::raw('SUM("HistorialPago"."MontoPagado") as TotalMontoPagado'), 'GastoMes.Fecha')
                                ->join('GastoComun', 'GastoComun.Id', '=', 'HistorialPago.GastoComunId')
                                ->join('GastoMes', 'GastoMes.Id', '=', 'GastoComun.GastoMesId')
                                ->where('GastoMes.ComunidadId', $comunidadId)
                                ->where('GastoMes.Id', '<=', $gastoMesId)
                                ->groupBy('GastoMes.Id', 'GastoMes.Fecha')
                                ->limit(12)
                                ->get();
                            

        $evolucionEgresos = GastoMe::select('TotalMes','Fecha')
                                ->where('GastoMes.ComunidadId', $comunidadId)
                                ->where('GastoMes.Id','<=', $gastoMesId)
                                ->where('GastoMes.EstadoId',2)
                                ->limit(12)
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
            'propiedadesOcupadas' => $propiedadesOcupadas,
            'fondoReserva' => $fondoReserva,
            'morosidad' => $morosidad,
            'evolucionIngresos' => $evolucionIngresos,
            'evolucionEgresos' => $evolucionEgresos
        ]);
    }
}
