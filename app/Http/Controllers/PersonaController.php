<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function Guardar(Request $request){
        $request = $request->input('data');   
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);

        try{
            $persona = new Persona();
            $persona->validate($request);
            $persona->fill($request);
            $persona->save();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function VerId(Request $request){
        $request = $request->input('data');

        try{
            $persona = Persona::find($request);
            return response()->json([
                'success' => true,
                'data' => $persona,
        ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function Editar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
    
        try{
            $persona = new Persona();
            $persona->validate($request);

            $personaEdit = Persona::find($request['Id']);
            //$userEdit->Username
            $personaEdit->fill($request);

            $personaEdit->save();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){ 
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
            }
    }

    public function CambioEstado(Request $request){
        $request = $request->input('data');
    
        try{
            $personaEdit = Persona::find($request);
            DB::beginTransaction();
            $personaEdit->update([
                   'Enabled' => ($personaEdit['Enabled'] == 1)? 2: 1 
            ]);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
        
        }
}
