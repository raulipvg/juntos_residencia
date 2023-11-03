<?php

namespace App\Http\Controllers;

use App\Models\GastoMe;
use App\Models\GastosDetalle;
use App\Models\TipoDocumento;
use App\Models\TipoGasto;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Exception;

class GastosDetalleController extends Controller
{
    //
    public function NuevoGasto(Request $request){
        $request = $request->input('data');

       /* $html = View('gastodetalle._nuevogasto')
                    ->with([
                            'variable' => 'Soy una variable pulenta 1'  
                            ])->render(); */
                               
         $tipogastos = TipoGasto::select('Id','Nombre')->orderBy('Nombre','asc')->get();
         $tipodco = TipoDocumento::select('Id','Nombre')->orderBy('Nombre','asc')->get();
         //$variable= "caca";

        try{
            return view('gastodetalle._nuevogasto', compact('tipogastos','tipodco'));

        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function index(Request $request){
        $variable = 'Soy una variable pulenta 2';

            return view('gastodetalle._nuevogasto')
                    ->with([
                        'variable' => $variable ])->render();
    }

    public function Guardar(Request $request){
        $request = $request->input('data');
        
        //$request['GastoMesId'] = $request['GastoMesId'];
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Responsable'] = strtolower($request['Responsable']);
        $request['Descripcion'] = strtolower($request['Descripcion']);
        $request['NroDocumento'] = strtolower($request['NroDocumento']);
        $request['TipoDocumentoId'] = $request['TipoDocumentoId'];
        $request['Precio'] = $request['Precio'];
        $request['TipoGastoId'] = $request['TipoGastoId'];

        try{
            $gastodetalle = new GastosDetalle();
            $gastodetalle->validate($request);
            $gastodetalle->fill($request);
   
            $gastodetalle->save(); 
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
