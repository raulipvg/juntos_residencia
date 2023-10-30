<?php

namespace App\Http\Controllers;

use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Exception;

class GastosDetalleController extends Controller
{
    //
    public function NuevoGasto(Request $request){
        $request = $request->input('data');

        $html = View('gastodetalle._nuevogasto')
                    ->with([
                        'variable' => 'Soy una variable pulenta'
                    ])->render();

       

        try{
            return response()->json([
                'success' => true,
                'html'=> $html,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
}
