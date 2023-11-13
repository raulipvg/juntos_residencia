<?php

namespace App\Http\Controllers;

use App\Models\GastoMe;
use App\Models\GastosDetalle;
use App\Models\TipoDocumento;
use App\Models\TipoGasto;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class GastosDetalleController extends Controller
{
    //
    public function NuevoGasto(Request $request){
        $request = $request->input('data');

       /* $html = View('gastodetalle._nuevogasto')
                    ->with([
                            'variable' => 'Soy una variable pulenta 1'  
                            ])->render(); */
        //falta filtrar por ComunidadId                
         $tipogastos = TipoGasto::select('Id','Nombre')
                                ->orderBy('Nombre','asc')->get();

         $tipodco = TipoDocumento::select('Id','Nombre')->orderBy('Nombre','asc')->get();

        try{
            return view('gastodetalle._nuevogasto', compact('tipogastos','tipodco'));

        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function Index(Request $request){
        $variable = 'Soy una variable pulenta 2';

            return view('gastodetalle._nuevogasto')
                    ->with([
                        'variable' => $variable ])->render();
    }

    public function Guardar(Request $request){
        $info = $request->input('info');
        $request = $request->input('data');
        
        //$request['GastoMesId'] = $request['GastoMesId'];
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Responsable'] = strtolower($request['Responsable']);
        $request['Detalle'] = strtolower($request['Detalle']);
        $request['NroDocumento'] = strtolower($request['NroDocumento']);
        $request['GastoMesId'] = $info['gastoMesId'];
        $request['TipoGastoId'] = $request['TipoGasto'];

        try{
            $gastodetalle = new GastosDetalle();
            $gastodetalle->validate($request);
            $gastodetalle->fill($request);

            $gastoMesEdit = GastoMe::find($request['GastoMesId']);
            DB::beginTransaction();
            if( $gastoMesEdit ){
                //Si es Gasto ADM - REMUNERACION
                if( $request['TipoGastoId'] == '1'){
                    $gastoMesEdit->TotalRemuneracion = $gastoMesEdit->TotalRemuneracion + $request['Precio'];
                    $gastoMesEdit->TotalAdm = $gastoMesEdit->TotalAdm + $request['Precio'];
                //SI ES GASTO ADM - CAJA CHICA
                }else if( $request['TipoGastoId'] == '2'){
                    $gastoMesEdit->TotalCajaChica += $request['Precio'];
                    $gastoMesEdit->TotalAdm += $request['Precio'];
                //SI ES GASTO ADM - Otros Gastos
                }else if( $request['TipoGastoId'] == '6'){
                    $gastoMesEdit->TotasOtros += $request['Precio'];
                    $gastoMesEdit->TotalAdm += $request['Precio'];
                //SO ES GASTO DE USO O CONSUMO
                }else if( $request['TipoGastoId'] == '3'){
                    $gastoMesEdit->TotalConsumo += $request['Precio'];        
                //SI ES GASTO DE MANTENCION
                }else if( $request['TipoGastoId'] == '4'){
                    $gastoMesEdit->TotalMantencion += $request['Precio'];
                //SI ES GASTO DE REPARACION
                }else if( $request['TipoGastoId'] == '5'){
                    $gastoMesEdit->TotalReparacion += $request['Precio'];
                }
                $gastoMesEdit->TotalMes= $gastoMesEdit->TotalAdm+ 
                                         $gastoMesEdit->TotalConsumo+
                                         $gastoMesEdit->TotalMantencion+
                                         $gastoMesEdit->TotalReparacion;

                $gastoMesEdit->FondoReserva = round(($gastoMesEdit->TotalMes) * ($gastoMesEdit->PorcentajeFondo / 100)); //Redondeo hacia arriba
                
                $gastoMesEdit->Total = $gastoMesEdit->TotalMes + $gastoMesEdit->FondoReserva;               
                $gastoMesEdit->update();
            }
            $gastodetalle->save(); 
            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);

        }catch(Exception $e){
            DB::rollback();   
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
}
