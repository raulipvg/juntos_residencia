<?php

namespace App\Http\Controllers;

use App\Models\HojaVida;
use App\Models\Persona;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class HojaVidaController extends Controller
{
    public function Index(Request $request){
        $IdPersona = $request->input('data');
        try {
            $hojavida = HojaVida::where('PersonaId', $IdPersona)->get();
            $Personas = Persona::select('Id','Nombre','Apellido')
                                 ->where('Id', '=', $IdPersona)->first();

            return response()->json([
            'success' => true,
            'data' => $hojavida,
            'persona' => $Personas,
        ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'persona' => $Personas]);
        }
    }

    public function Guardar(Request $request){

        $request = $request->input('data');
        $IdPersona = $request['PersonaId'];

        $personas = Persona::findorfail($IdPersona);

        $request['Titulo'] =  strtolower($request['Titulo']);
        $request['Descripcion'] = strtolower($request['Descripcion']);

        try {
            $hojavida = new HojaVida();
            $hojavida->persona()->associate($personas);
            $hojavida->validate($request);
            $hojavida->fill($request);
            $hojavida->save();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function VerId(Request $request){

        $IdHojaVida= $request->input('data');
        
        try{

           $hojavida = HojaVida::with('persona')->find( $IdHojaVida );
           return response()->json([
               'success' => true,
               'data' => $hojavida ]);
       }catch(Exception $e){
               
           return response()->json([
               'success' => false,
               'message' => $e->getMessage()]);
       }
    }

    public function Editar(Request $request){
            $request = $request->input('data');
            $IdHojaVida= $request["Id"];
            try{
    
                $hojavida = HojaVida::findOrFail($IdHojaVida);
                $hojavida->validate($request);
            
                $hojavida->update([
                        'Titulo' => $request['Titulo'],
                        'Descripcion' => $request['Descripcion'],
                        'Fecha' => $request['Fecha'],
                        'Enabled' => $request['Enabled']
                 ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Modelo recibido y procesado']);
            }catch(Exception $e){
                    
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()]);
            }
    }

    public function CambiarEstadoHojaVida(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo

        try{
            $hojavidaEdit = HojaVida::find($request);
            DB::beginTransaction();
            $hojavidaEdit->update([
                   'Enabled' => ($hojavidaEdit['Enabled'] == 1)? 2: 1 
            ]);
            //$usuario->save();
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


