<?php

namespace App\Http\Controllers;

use App\Models\Compone;
use App\Models\Comunidad;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\RolComponeCoRe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponeController extends Controller
{
    public function Index(){
        $componen = Compone::all();
        $personas = Persona::select('Id', 'RUT', 'Nombre', 'Apellido', 'Sexo', 'Telefono', 'Email', 'Enabled')->get();
        $rolesComponeCoRe = RolComponeCoRe::select('Id','Nombre')->get();
        $nacionalidades = Nacionalidad::select('Id','Nombre')->get();
        $propiedades = Propiedad::select('Id','Numero')->get();
        $comunidades = Comunidad::select('Id','Nombre')->get();
        return view("residente.residente")->with([
            'Componen' => $componen,
            'Personas'=> $personas,
            'RolesComponenCoRe'=> $rolesComponeCoRe,
            'Nacionalidades'=> $nacionalidades,
            'Comunidades' => $comunidades,
            'Propiedades' => $propiedades
        ]);
    }

    public function Guardar(Request $request){
        //Crea Persona y Compone, requiere usar transacción (ver controlador ResidenteController anterior)
        $request = $request->input('data');
        // Accede a los atributos del modelo    

        try{

            $compone = Compone::create([
                'PersonaId' => $request['PersonaId'],
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],
            ]);
            $compone->save();


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
            $compone = Compone::select('Comunidad.Nombre as Comunidad', 'Propiedad.Numero as Propiedad','RolComponeCoRe.Nombre as Rol','FechaInicio','FechaFin','Compone.Enabled')
            ->where('Compone.PersonaId','=',$request)
            ->join('Propiedad', 'Propiedad.Id', '=', 'Compone.PropiedadId')
            ->join('Comunidad', 'Comunidad.Id', '=', 'Propiedad.ComunidadId')
            ->join('RolComponeCoRe', 'RolComponeCoRe.Id', '=', 'Compone.RolComponeCoReId')->get();
            return response()->json([
                'success' => true,
                'data' => $compone]);

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
            $componeEdit = compone::find($request['Id']);

            $compone = new Compone();

            $compone->validate([
                'PersonaId' => $componeEdit->persona->Id,
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],             
            ]);


            $componeEdit->update([
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],   
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
}
