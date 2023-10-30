<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class GastoMesController extends Controller
{
    public function Index(){
        return View('gastomes.gastomes');
    }

    public function AbrirMes(Request $request){
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
