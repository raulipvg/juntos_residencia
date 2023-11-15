<?php

namespace App\Http\Controllers;

use App\Models\Compone;
use App\Models\EstadoPago;
use App\Models\GastoComun;
use App\Models\GastoMe;
use App\Models\HistorialPago;
use App\Models\Propiedad;
use App\Models\TipoPago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialPagoController extends Controller
{
    // Acción que trae las tuplas de pagos
    public function Index(Request $request){
        $request = $request->data;

        
        if($request==null){
            $comunidadId = 12;                 // recibe el id de la comunidad, el mes y año del período, id de gasto comun
            $gastosMeses = GastoMe::select('Id','Fecha')
                                ->where('ComunidadId', $comunidadId)
                                ->where('EstadoId','2')
                                ->orderBy('Fecha','desc')
                                ->get();
            $gastosComunesMes = $gastosMeses->first();
        }
        else{
            $comunidadId = $request['ComunidadId'];
            $gastosComunesMes['Id'] = $request["idMes"];
        }
        $historialesPagos = HistorialPago::select('GastoComunId','EstadoPagoId','EstadoPago.Nombre')
                            ->join('GastoComun','HistorialPago.GastoComunId','=','GastoComunId')
                            ->join('GastoMes','GastoComun.GastoMesId','=','GastoMes.Id')
                            ->join('EstadoPago', 'HistorialPago.EstadoPagoId', '=', 'EstadoPago.Id')
                            ->where('GastoMes.ComunidadId', $comunidadId)
                            ->orderBy('HistorialPago.FechaPago')
                            ->get();
        $gastosComunes = GastoComun::where("GastoMesId", "=", $gastosComunesMes['Id'])
                            ->get();
        $tiposPagos = TipoPago::select("Id","Nombre")->get();
        $estados = EstadoPago::select("Id","Nombre")->get();
        if($request == null) {
            try{
                return view("historialpago.historialpago")->with([
                    'gastosmeses' => $gastosMeses,
                    'GastosComunes'=> $gastosComunes,
                    'HistorialesPagos' => $historialesPagos,
                    'TiposPagos' => $tiposPagos,
                    'Estados' => $estados
                ]);
            }catch(\Exception $ex){
                return $ex;
            }
        }
        else{
            try{
                return view("historialpago._historial")->with([
                    'GastosComunes'=> $gastosComunes,
                    'HistorialesPagos' => $historialesPagos,
                    'TiposPagos' => $tiposPagos,
                    'Estados' => $estados
                ]);
            }catch(\Exception $ex){
                return $ex;
            }
        }
       
    }

    // Acción que guarda el registro del pago
    public function GuardarPago(Request $request){
        $request = $request->data;

        $historialesDeGC = HistorialPago::where('GastoComunId','=', $request["gastoComunId"])
                                        ->orderBy('FechaPago','desc')
                                        ->get();
        if($historialesDeGC[0]['EstadoPagoId'] == '1'){
            
            if( ((int)$historialesDeGC[0]['MontoAPagar']) > $request['MontoPago'] )
                $estado = 2;
            else
                $estado = 3;

            try{
                $historialModificar = HistorialPago::find($historialesDeGC[0]['Id']);

                if($historialModificar['MontoAPagar'] <= $request['MontoPago']){
                    return response()->json([
                        'success' => false,
                        'message' => 'El monto pagado no puede ser mayor al monto por pagar']);
                }

                if($historialModificar['MontoAPagar'] < 1){
                    return response()->json([
                        'success' => false,
                        'message' => 'El monto pagado no puede ser menor o igual a 0']);
                }

                $historialModificar->update([
                    'NroDoc'=> $request['NumDoc'],
                    'TipoPagoId'=> $request['TipoPago'],
                    'FechaPago' => Carbon::now(),
                    'MontoAPagar' => $historialesDeGC[0]['MontoAPagar']-(int)$request['MontoPago'],
                    'MontoPagado'=> $request['MontoPago'],
                    'EstadoPagoId'=> $estado,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Modelo recibido y procesado']);
            }
            catch(\Exception $ex){
                return response()->json([
                    'success' => false,
                    'message' => $ex->getMessage()]);
            }
        }
        
        if($historialesDeGC[0]['EstadoPagoId'] == 2 ){


            if(( (int)$request['MontoPago'] ) < 0){
                if((int)$request['MontoPago'] <=0){
                    return response()->json([
                        'success' => false,
                        'message' => 'El monto pagado no puede ser menor o igual a 0']);
                }
                $estado = 2;
            }
            else{
                if((int)$request['MontoPago'] > $historialesDeGC[0]['MontoAPagar']){
                    return response()->json([
                        'success' => false,
                        'message' => 'El monto pagado no puede ser mayor al monto por pagar']);
                }

                $estado = 3;
            }
            try{
                $nuevoHistorial = HistorialPago::create([
                    'NroDoc'=> $request['NumDoc'],
                    'TipoPagoId'=> $request['TipoPago'],
                    'FechaPago' => Carbon::now(),
                    'MontoAPagar' => $historialesDeGC[0]['MontoAPagar']-(int)$request['MontoPago'],
                    'MontoPagado'=> $request['MontoPago'],
                    'GastoComunId' => $request['gastoComunId'],
                    'EstadoPagoId'=> $estado
                ]);


                return response()->json([
                    'success' => true,
                    'message' => 'Modelo recibido y procesado']);
            }
            catch(\Exception $ex){
                return response()->json([
                    'success' => false,
                    'message' => $ex->getMessage()]);
            }
            
        }
    }

    public function UltimoRegistroPorGC(Request $request){
        try{
            $montoAdeudado = HistorialPago::select('MontoAPagar')
                                ->where('GastoComunId','=', $request['data'])
                                ->orderBy('FechaPago','desc')
                                ->get()
                                ->first();
            return response()->json([
                    'success' => true,
                    'data' => $montoAdeudado]);
        }
        catch(\Exception $ex){
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()]);
        }
        
    }

    public function Ver(Request $request){
        try{
            $historialDeGc = HistorialPago::select('HistorialPago.Id','FechaPago','MontoPagado','TipoPago.Nombre as TipoPago','NroDoc','EstadoPago.Nombre as Estado')
                                ->join('EstadoPago','EstadoPago.Id','=','EstadoPagoId')
                                ->join('TipoPago','TipoPago.Id','=','TipoPagoId')
                                ->where('GastoComunId', '=', $request['data'])
                                ->orderBy('FechaPago','desc')
                                ->get();

            return response()->json([
                'success' => true,
                'data' => $historialDeGc]);
        }
        catch(\Exception $ex){
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()]);
        }
    }
}
