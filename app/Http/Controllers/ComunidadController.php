<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComunidadController extends Controller
{
    public function Index(){

    }
    public function Guardar(Request $request){
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
    public function VerId(Request $request){
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
    public function Editar(Request $request){
        return response()->json([
            'success' => true,
            'message' => 'Modelo recibido y procesado']);
    }
}
