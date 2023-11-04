<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use Illuminate\Http\Request;
use Exception;

use function Laravel\Prompts\select;

class GastoMesController extends Controller
{
    public function Index(){
        $comunidades = Comunidad::select('Id','Nombre')->get();
        return View('gastomes.gastomes')->with([
            'comunidades'=> $comunidades
        ]);
    }

    public function AbrirMes(Request $request){
        $request = $request->input('data');

        // $request['ComunidadId'] = $request['ComunidadId'];
        // $request['Fecha'] = $request['Fecha'];
        // $request['TotalRemuneracion'] = 0;
        // $request['TotalOtros'] = 0;
        // $request['TotalAdm'] = 0;
        // $request['TotalConsumo'] = 0;
        // $request['TotalMantencion'] = 0;
        // $request['TotalReparacion'] = 0;
        // $request['TotalMes'] = 0;
        // $request['PorcentajeFondo'] = 5;
        // $request['FondoReserva'] = 0;
        // $request['Total'] = 0;
        // $request['EstadoId'] = 1;
        
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

    public function CerrarMes(Request $request){
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
