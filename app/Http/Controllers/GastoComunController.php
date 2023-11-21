<?php

namespace App\Http\Controllers;

use App\Models\CobroIndividual;
use App\Models\Comunidad;
use App\Models\GastoComun;
use App\Models\Propiedad;
use App\Models\Persona;
use App\Models\GastoMe;
use App\Models\HistorialPago;
use App\Models\ReservaEspacio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class GastoComunController extends Controller
{
    public function VerGastosComunes(Request $request){
        $flag= false;//FALTA SEGUN USER

        if( $request->input('c') != null ){
            $comunidadId = $request->input('c');

            $gasto =  GastoMe::select('Id','TotalMes','FondoReserva','Total','Fecha')
                                ->where('ComunidadId', $comunidadId)
                                //->where('EstadoId', 2)
                                //->latest('Fecha')
                                ->first();
            $comunidades = Comunidad::select('Id','Nombre')
                                ->where('Enabled', 1)
                                ->orderBy('Nombre','asc')
                                ->get();
            if(isset($gasto)){
                //GASTOS MENSUALES DE TODOS LOS PROPIETARIOS SEGUN UN GASTO DE MES DETERMINADO               
                $gastosComunes = GastoComun::select('GastoComun.CobroGC','GastoComun.FondoReserva',
                        'GastoComun.TotalGC','GastoComun.SaldoMesAnterior',
                        'GastoComun.TotalCobroMes','Propiedad.Numero',
                        'Propiedad.Prorrateo','Propiedad.Id',
                        'Persona.Nombre','Persona.Apellido', 'GastoComun.CobroIndividual')
                                    ->where('GastoComun.GastoMesId', $gasto->Id)
                                    ->join('Propiedad','Propiedad.Id','=','GastoComun.PropiedadId')
                                    ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                                    ->where('Compone.Enabled', 1)
                                    ->where('Compone.RolComponeCoReId', 1)
                                    ->join('Persona','Persona.Id','=','Compone.PersonaId')
                                    ->get();
            }else{
                $gastosComunes = null;
            }
            //TODOS LOS GASTOS MES PARA UNA COMUNIDAD SELECT2
            $gastosMeses = GastoMe::select('Id','Fecha')
                                ->where('ComunidadId', $comunidadId)
                                ->where('EstadoId', 2)
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

        $comunidadId= 12;
        $request = $request->input("data");

        
        //Para colocar el nombre del mes en español 
        setlocale(LC_ALL, 'es');

        if(isset($request['ComunidadId']) &&  isset($request['GastoMesId'])){
            $flag=true;
            $comunidadId =$request['ComunidadId'];

             //ULTIMO GASTO MES PARA UNA COMUNIDAD DETERMINADA
             $gasto =  GastoMe::select('Id','TotalMes','FondoReserva','Total','Fecha')
                                ->where('Id', $request['GastoMesId'])
                                //->where('EstadoId', 2)
                                //->latest('Fecha')
                                ->first();

            //GASTOS MENSUALES DE TODOS LOS PROPIETARIOS SEGUN UN GASTO DE MES DETERMINADO               
            $gastoscomunes = GastoComun::select('GastoComun.CobroGC','GastoComun.FondoReserva',
                                                'GastoComun.TotalGC','GastoComun.SaldoMesAnterior',
                                                'GastoComun.TotalCobroMes','Propiedad.Numero',
                                                'Propiedad.Prorrateo','Propiedad.Id',
                                                'Persona.Nombre','Persona.Apellido', 'GastoComun.CobroIndividual')
                                        ->where('GastoComun.GastoMesId', $gasto->Id)
                                        ->join('Propiedad','Propiedad.Id','=','GastoComun.PropiedadId')
                                        ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                                        ->where('Compone.Enabled', 1)
                                        ->where('Compone.RolComponeCoReId', 1)
                                        ->join('Persona','Persona.Id','=','Compone.PersonaId')
                                        ->get();

            

        }else{
            $flag=false;
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
                    'Persona.Nombre','Persona.Apellido', 'GastoComun.CobroIndividual')
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
                                ->where('EstadoId', 2)
                                ->latest('Fecha')
                                ->get();

        }
          
         // SI ES POR LLAMADA AJAX SELECT2
         if($flag){            
            return view('gastocomun._vergastocomun', 
                    compact('gasto','gastoscomunes')
                );

        // SI ES UNA LLAMADA AL INDEX SIN PARAMETROS    
        }else{
            return view('gastocomun.gastocomun')->with([
                'comunidades'=> $comunidades,
                'comunidadId'=> $comunidadId, 
                'gasto'=> $gasto,
                'gastoscomunes' => $gastosComunes,
                'gastosmeses'=> $gastosMeses,
            ]);
        }
       

        
    }

    public function VerDetalle(Request $request){
         //FALTA SEGUN USER
         //$request = $request->input("data");
        $g = $request->input('g');
        $p = $request->input('p');
        $c = $request->input('c');

        $propiedadId = $p;
        $comunidadId= $c;
        $gastoMesId = $g;

         //setlocale(LC_TIME, 'es_ES.utf8');
         //Para colocar el nombre del mes en español 
         setlocale(LC_ALL, 'es');
         //TODAS LAS COMUNIDADES HABILITADAS
        $comunidades = Comunidad::select('Id','Nombre')
                                     ->where('Enabled', 1)
                                     ->orderBy('Nombre','asc')
                                     ->get();

        //ULTIMO GASTO MES PARA UNA COMUNIDAD DETERMINADA
        $gasto =  GastoMe::select('Id','TotalMes','FondoReserva','Total','Fecha','FechaFin','EstadoId')
                        ->where('ComunidadId', $comunidadId)
                        ->where('EstadoId', 2)
                        ->latest('Fecha')
                        ->first();

        //TODOS LOS GASTOS MES PARA UNA COMUNIDAD SELECT2
        $gastosMeses = GastoMe::select('Id','Fecha','FechaFin','EstadoId')
                            ->where('ComunidadId', $comunidadId)
                            //->where('EstadoId', 2)
                            ->latest('Fecha')
                            ->get();

        // DATOS DE LA PROPIEDAD EN ESPECÍFICO: TIPO, NUMERO, PRORRATEO
        $propiedadGC = Propiedad::select('TipoPropiedad.Nombre as Tipo','Propiedad.Numero as Numero','Propiedad.Prorrateo as Prorrateo')
                                ->join('TipoPropiedad', 'Propiedad.TipoPropiedad', '=', 'TipoPropiedad.Id')
                                ->where('Propiedad.Id', $propiedadId)
                                ->first();

        // DATOS DE LA COMUNIDAD EN ESPECÍFICO: NOMBRE, RUT, NRO CUENTA, TIPO CUENTA, BANCO, EMAIL, TELEFONO, DOMICILIO, TIPO
        $comunidadGC = Comunidad::select('Comunidad.Id','Comunidad.Nombre','RUT','Correo','TipoCuenta','NumeroCuenta','Banco','TipoComunidad.Nombre as Tipo','Telefono','Domicilio')
                                ->join('TipoComunidad', 'Comunidad.TipoComunidadId', '=', 'TipoComunidad.Id')
                                ->where('Comunidad.Id', $comunidadId)
                                ->where('Enabled',1)
                                ->first();
        
        // DATOS DEL COPROPIETARIO DE LA PROPIEDAD
        $copropietario = Persona::select('Nombre','Apellido','RUT')
                                ->join('Compone', 'Persona.Id','Compone.PersonaId')
                                ->where('Compone.PropiedadId', $propiedadId)
                                ->where('Compone.Enabled', 1)
                                ->where('Compone.RolComponeCoReId', 1)
                                ->first();
        
        // DATOS DEL RESIDENTE de la propiedad
        $residente = Persona::select('Nombre','Apellido','RUT')
                            ->join('Compone', 'Persona.Id','Compone.PersonaId')
                            ->where('Compone.PropiedadId', $propiedadId)
                            ->where('Compone.Enabled', 1)
                            ->where('Compone.RolComponeCoReId', 2)
                            ->first();

        // GASTO COMUN DEL MES CONSULTADO DE LA COMUNIDAD
        $gastoComun = GastoComun::select('GastoMes.Total as TotalGC',
                                        'GastoMes.Fecha as Desde', 
                                        'GastoMes.FechaFin as Hasta',
                                        'GastoComun.Id as Folio',
                                        'GastoComun.CobroGC',
                                        'GastoComun.FondoReserva',
                                        'GastoComun.CobroIndividual',
                                        'GastoComun.TotalCobroMes',
                                        'GastoComun.FondoReserva',
                                        'GastoComun.Fecha',
                                        'GastoComun.SaldoMesAnterior',
                                    )
                                    ->join('GastoMes','GastoComun.GastoMesId','=','GastoMes.Id')
                                    ->where('GastoMesId',$gastoMesId)
                                    ->where('PropiedadId',$propiedadId)
                                    ->first();   

        //ÚLTIMOS PAGOS
        $ultimosPagos = HistorialPago::select('NroDoc','TipoPago.Nombre as TipoPago','FechaPago','MontoPagado')
                                        ->join('TipoPago','HistorialPago.TipoPagoId','=','TipoPago.Id')
                                        ->join('GastoComun','HistorialPago.GastoComunId','=','GastoComun.Id')
                                        ->where('GastoComun.PropiedadId', $propiedadId)
                                        ->where('HistorialPago.FechaPago','<',$gastoComun->Hasta)
                                        ->limit(4)
                                        ->get();
        
        //COBROS INDIVIDUALES
        $cobrosIndividuales = CobroIndividual::select('CobroIndividual.Nombre','CobroIndividual.Descripcion','CobroIndividual.MontoTotal')
                                            ->join('GastoComun','GastoComun.Id','=','CobroIndividual.GastoComunId')
                                            ->where('GastoComun.GastoMesId', $gastoMesId)
                                            ->where('GastoComun.PropiedadId', $propiedadId )
                                            ->get();

        //RESERVAS DE ESPACIOS
        $reservas = ReservaEspacio::select('ReservaEspacio.FechaUso',
                                        'EspacioComun.Nombre as Nombre',
                                        'ReservaEspacio.Total as Total')
                                    ->join('EspacioComun','EspacioComunId','=','EspacioComun.Id')
                                    ->join('GastoComun','ReservaEspacio.GastoComunId','=','GastoComun.Id')
                                    ->where('ReservaEspacio.EstadoReservaId', 2)
                                    ->where('GastoComun.GastoMesId',$gastoMesId)
                                    ->where('GastoComun.PropiedadId', $propiedadId)
                                    ->get();
        
        //SUMA DEL TOTAL DE LAS RESERVAS
        $totalReservas = ReservaEspacio::join('EspacioComun', 'EspacioComunId', '=', 'EspacioComun.Id')
                                    ->join('GastoComun', 'ReservaEspacio.GastoComunId', '=', 'GastoComun.Id')
                                    ->where('ReservaEspacio.EstadoReservaId', 2)
                                    ->where('GastoComun.GastoMesId', $gastoMesId)
                                    ->where('GastoComun.PropiedadId', $propiedadId)
                                    ->sum('ReservaEspacio.Total');

        $gastosComunesChart = GastoComun::select('TotalCobroMes','SaldoMesAnterior','Fecha')
                                    ->where('PropiedadId',$propiedadId)
                                    ->where('EstadoGastoId','!=',3)
                                    ->limit(13)
                                    ->orderBy('Fecha','asc')
                                    ->get();
        

        return view('gastocomun.verdetalle')->with([ 
            'comunidadId' => $comunidadId,
            'comunidades'=> $comunidades,
            'comunidadGC'=> $comunidadGC,
            'propiedadGC'=> $propiedadGC,
            'gastosmeses'=> $gastosMeses,
            'gasto'=> $gasto,
            'copropietario' => $copropietario,
            'residente' => $residente,
            'gastoComun' => $gastoComun,
            'cobrosIndividuales' => $cobrosIndividuales,
            'reservas' => $reservas,
            'totalReservas' => $totalReservas,
            'ultimosPagos' => $ultimosPagos,
            'gastosComunesChart' => $gastosComunesChart,
            'propiedadId' => $propiedadId
        ]);
    }

}
