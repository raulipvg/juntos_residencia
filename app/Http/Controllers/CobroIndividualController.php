<?php

namespace App\Http\Controllers;

use App\Models\CobroIndividual;
use App\Models\Comunidad;
use App\Models\GastoComun;
use App\Models\GastoMe;
use App\Models\Propiedad;
use App\Models\TipoCobro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CobroIndividualController extends Controller
{
    public function Index(Request $request){
        $variable = 'Soy una variable pulenta 2';
//FALTA SEGUN USER
        $comunidadId= 12;
        //TODAS LAS COMUNIDADES HABILITADAS
        $comunidades = Comunidad::select('Id','Nombre')
                            ->where('Enabled', 1)
                            ->orderBy('Nombre','asc')
                            ->get();

        $propiedades = Propiedad::select('Propiedad.Id','Propiedad.Numero',
                                         'Persona.Nombre','Persona.Apellido',
                                        )
                            ->where('Propiedad.ComunidadId', $comunidadId)
                            ->where('Propiedad.Enabled', 1) //Propeidad Habilitada
                            ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                            ->where('Compone.RolComponeCoReId', 1) //Es propietario
                            ->where('Compone.Enabled', 1) // Es propietario Actual
                            ->join('Persona','Persona.Id','=','Compone.PersonaId')
                            ->get();
         
                            //EL GASTO DE MES PARA UNA COMUNIDAD Y FECHA ESTABLECIDA
         $gasto =  GastoMe::select('Id')
         ->where('ComunidadId', $comunidadId)
         ->latest('Fecha')
         ->first();

         //TODOS LOS GASTOS MES PARA UNA COMUNIDAD SELECT2
         $gastosMeses = GastoMe::select('Id','Fecha','EstadoId')
         ->where('ComunidadId', $comunidadId)
         ->latest('Fecha')
         ->get();

        return view('cobroindividual.cobroindividual')->with([
            'comunidades'=> $comunidades,
            'comunidadId'=> $comunidadId,
            'propiedades'=> $propiedades,
            'gastosmeses'=> $gastosMeses,
            'gasto'=> $gasto,
        ]);
    }

    public function VerCobro(Request $request){
        $wea= "wea";
        $request = $request->input('data');
        try{
            $gastoMes = GastoMe::select('Id','Fecha', 'EstadoId')
                            ->where('Id', $request['gastoMesId'])
                            ->first();
            //SI ES EL GASTO MES ESTA ABIERTO, \
            //HAY QUE BUSCAR DIRECTAMENTE EN LA TABLA COBRO INDIVIDUAL
            if($gastoMes->EstadoId == 1){
                $cobros = CobroIndividual::select('CobroIndividual.Nombre','CobroIndividual.Descripcion',
                                        'CobroIndividual.MontoTotal','TipoCobro.Nombre as TipoCobro','CobroIndividual.Fecha')
                                        ->where('CobroIndividual.EstadoId', 1)
                                        ->where('CobroIndividual.PropiedadId', $request['propiedadId'])
                                        ->join('TipoCobro','TipoCobro.Id','=','CobroIndividual.TipoCobroId')
                                        ->get();
                $propiedad = Propiedad::select('Id','Numero')
                                    ->where('Id', $request['propiedadId'])
                                    ->first();
            }

            return view('cobroindividual._vercobro', compact('cobros','propiedad'));

        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
    public function AgregarCobro(Request $request){
        $request = $request->input('data');
        $propiedadId= $request['propiedadId'];
        try{
            $propiedad = Propiedad::select('Id','Numero')
                                ->where('Id', $propiedadId)
                                ->first();

            $tipoCobros = TipoCobro::select('Nombre','Id','Precio')
                        ->where('ComunidadId', $request['comunidadId'] )
                        ->where('Enabled', 1 )
                        ->where('Precio', 0 )
                        ->get();
            return view('cobroindividual._agregarcobro', 
                    compact('propiedad','tipoCobros'));

        }catch(Exception $e){     
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function GuardarCobro(Request $request){
        $request = $request->input('data');
        try{
            $request['Nombre'] = strtolower($request['Nombre']);
            $request['Descripcion'] = strtolower($request['Descripcion']);
            $request['Cantidad'] = 0;
            $request['GastoComunId'] = null;
            $request['EstadoId'] = 1; //NO ASIGNADO A UN GastoComun
            $request['Fecha'] = Carbon::now();
            
            $cobroIndividual = new CobroIndividual();
            $cobroIndividual->validate($request);
            $cobroIndividual->fill($request);
            $cobroIndividual->save();

            return response()->json([
                'success' => true,
                'data' =>  "wena" ]);

        }catch(Exception $e){     
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    
    
    }
}
