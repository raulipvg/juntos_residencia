<?php

namespace App\Http\Controllers;

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
}
