<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\Residente;
use App\Models\RolResidente;
use Illuminate\Http\Request;
use Exception;

class ResidenteController extends Controller
{
    public function Index(){
        $residentes = Residente::all();
        $personas = Persona::select('Id', 'Nombre', 'Apellido', 'RUT')->get();
        $propiedades = Propiedad::select('Id', 'Numero')->get();
        $roles = RolResidente::select('Id','Nombre')->get();
        return View('Residente.residentes')->with([
            'Residentes' => $residentes,
            'Personas' => $personas,
            'Propiedades' => $propiedades,
            'Roles' => $roles
        ]);
    }
    public function Guardar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['FechaInicio']= $request['FechaInicio'] = now();
        $request['FechaFin']= $request['FechaFin'];

        
     
     try{
         $residente = new Residente();
         $residente->validate($request);
         $residente->fill($request);

         
         $residente->save(); 
         return response()->json([
             'success' => true,
             'message' => 'Modelo recibido y procesado']);
     }catch(Exception $e){
             
         return response()->json([
             'success' => false,
             'message' => $e->getMessage()]);
     }
    }

    public function VerId(Request $request){
        
        $request = $request->input('data');

        try{

            $residente= Residente::find($request);
            return response()->json([
                'success' => true,
                'data' => $residente ]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function Editar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['FechaInicio']= $request['FechaInicio']= now();
        $request['FechaFin']= $request['FechaFin'];

         try{
            $residente = new Residente();
            $residente->validate($request);

            $residenteEdit = Residente::find($request['Id']);
            //$userEdit->Username
            $residenteEdit->fill($request);

            $residenteEdit->save();

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
