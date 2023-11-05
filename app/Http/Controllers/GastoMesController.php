<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\GastoComun;
use App\Models\GastoMe;
use App\Models\HistorialPago;
use App\Models\Propiedad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class GastoMesController extends Controller
{
    public function Index(){
        //FALTA SEGUN USER
        $comunidadId= 12;

        $comunidades = Comunidad::select('Id','Nombre')
                            ->where('Enabled', 1) 
                            ->get();

        $gastosMeses = GastoMe::select('Id','Fecha')
                            ->where('ComunidadId', $comunidadId)
                            ->get();

        $gastoMes =  GastoMe::with('gastos_detalles')
                            ->where('ComunidadId', $comunidadId)
                            ->first();
        
        return View('gastomes.gastomes')->with([
                        'comunidades'=> $comunidades,
                        'gastosmeses'=> $gastosMeses,
                        'gasto' => $gastoMes,
                        'comunidadId'=> $comunidadId
                    ]);
    }

    public function AbrirMes(Request $request){
        $request = $request->input('data');
        $mesActual = Carbon::now();
        $existeGasto = GastoMe::where('ComunidadId',$request)
                                ->whereYear('Fecha',$mesActual->year)
                                ->whereMonth('Fecha',$mesActual->month)
                                ->exists();                   
        try{
            // NO EXISTE GASTO COMUN PARA EL MES ACTUAL Y COMUNIDAD INDICADA                         
            if(!$existeGasto){
                $aux = [];
                $aux['ComunidadId'] = $request;
                $aux['Fecha'] = $mesActual;
                $aux['TotalRemuneracion'] = 0;
                $aux['TotasOtros'] = 0;
                $aux['TotalAdm'] = 0;
                $aux['TotalConsumo'] = 0;
                $aux['TotalCajaChica'] = 0;
                $aux['TotalMantencion'] = 0;
                $aux['TotalReparacion'] = 0;
                $aux['TotalMes'] = 0;
                $aux['PorcentajeFondo'] = 5;
                $aux['FondoReserva'] = 0;
                $aux['Total'] = 0;
                $aux['EstadoId'] = 1;

                $gastoMes = new GastoMe();

            //$gastoMes->validate($request);
                $gastoMes->fill($aux);
                $gastoMes->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Modelo recibido y procesado']);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Ya Existe Gasto Mensual']);
            }   
            
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }

    }

    public function CerrarMes(Request $request){
        $request = $request->input('data');
        

        try{
            $gastoMesEdit = GastoMe::find($request['gastoMesId']);
           
            if($gastoMesEdit){
                DB::beginTransaction();
                $fechaActual = Carbon::now();
                $gastoMesEdit->update([
                    'EstadoId'=> 2
                ]);
                $propiedades = Propiedad::Select('Id','Prorrateo')
                                    ->where('ComunidadId', $request['ComunidadId'])
                                    ->where('Enabled', 1) 
                                    ->get();
                foreach($propiedades as $propiedad){
                    $cobroGC = round($gastoMesEdit->TotalMes * ($propiedad->Prorrateo/100)); 
                    $fondoReserva = round($gastoMesEdit->FondoReserva * ($propiedad->Prorrateo/100));
                    
                    $totalGC = $cobroGC+$fondoReserva;
                    ///*******///
                    // FALTA AGREGAR LA SUMA DE LOS COBROS INDIVUALES DE LAS TABLAS DE COBRO INDIVUAL
                    // Y RESERVA DE ESPACOP
                    $cobroIndividual =0;
                    $totalCobroMes =$totalGC+ $cobroIndividual;

                    ///*******///
                    //FALTA OBTENER EL SALDO MES ANTERIOR SEGUN HISTORIAL DE PAGO
                    $saldoMesAnterior = 0;

                    $gastoComun = GastoComun::create([
                        'PropiedadId'=> $propiedad['Id'],
                        'CobroGC'=> $cobroGC,
                        'FondoReserva'=> $fondoReserva,
                        'TotalGC'=> $totalGC,
                        'TotalCobroMes'=>$totalCobroMes,
                        'Fecha'=> $fechaActual,
                        'SaldoMesAnterior'=> $saldoMesAnterior,
                        'GastoMesId'=> $request['gastoMesId'],
                        'EstadoGastoId'=> 1,
                    ]);

                    $historialPago = HistorialPago::Create([
                        'NroDoc'=> null,
                        'TipoPagoId'=> null,
                        'FechaPago'=> $fechaActual,
                        'MontoAPagar'=> $totalCobroMes,
                        'MontoPagado'=> 0,
                        'GastoComunId'=> $gastoComun->Id,
                        'EstadoPagoId'=> 1
                    
                    ]);
                }
                DB::commit(); 

                return response()->json([
                    'success' => true,
                    'message' => 'Modelo recibido y procesado']);
            }

        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }

    }

    public function VerMeses(Request $request){
        $request = $request->input('data');


        try{
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    
}
