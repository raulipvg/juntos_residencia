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
        $personas = Persona::select('Id', 'RUT', 'Nombre', 'Apellido', 'Sexo', 'Telefono', 'Email')->get();
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
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);

        try{
            $persona = new Persona();
            $persona->validate([
                'RUT' => $request['Rut'],
                'Nombre'=> $request['Nombre'],
                'Apellido'=> $request['Apellido'],
                'Sexo'=> $request['SexoId'],
                'Telefono'=> $request['Telefono'],
                'Email'=> $request['Correo'],
                'NacionalidadId'=> $request['NacionalidadId'],
                'Enabled' => $request['Enabled']
            ]);

            $compone = new Compone();
            
            $compone->validate([
                'PersonaId' => 1,
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],
            ]);

            DB::beginTransaction();
            $persona = Persona::create([
                'RUT' => $request['Rut'],
                'Nombre'=> $request['Nombre'],
                'Apellido'=> $request['Apellido'],
                'Sexo'=> $request['SexoId'],
                'Telefono'=> $request['Telefono'],
                'Email'=> $request['Correo'],
                'Enabled'=> $request['Enabled'],
                'NacionalidadId'=> $request['NacionalidadId']
            ]);

            $compone = Compone::create([
                'PersonaId' => $persona->Id,
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function VerId(Request $request){
        $request = $request->input('data');

        try{
            $compone = Compone::find($request);
            return response()->json([
                'success' => true,
                'data' => $compone,
                'persona' => $compone->persona, 
                'propiedad'=> $compone->propiedad]);

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

            $persona = New Persona();
            $persona->validate([
                'Id' => $componeEdit->persona->Id,
                'RUT' => $request['Rut'],
                'Nombre'=> $request['Nombre'],
                'Apellido'=> $request['Apellido'],
                'Sexo'=> $request['SexoId'],
                'Telefono'=> $request['Telefono'],
                'Email'=> $request['Correo'],
                'NacionalidadId'=> $request['NacionalidadId'],
                'Enabled' => $request['Enabled']
            ]);

            $compone = new Compone();

            $compone->validate([
                'PersonaId' => $componeEdit->persona->Id,
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],             
            ]);

            //$residente->fill($request);
            // Usamos transacción para asegurar la integridad de los datos
            DB::beginTransaction();

            $componeEdit->update([
                'PropiedadId'=> $request['PropiedadId'],
                'RolComponeCoReId'=> $request['RolId'],
                'FechaInicio'=> $request['FechaInicio'],
                'FechaFin'=> $request['FechaFin'],
                'Enabled'=> $request['Enabled'],   
            ]);
            //$userEdit->Username
            //$residenteEdit->fill($request);
            $personaEdit= $componeEdit->persona;
            $personaEdit->update([
                'RUT' => $request['Rut'],
                'Nombre'=> $request['Nombre'],
                'Apellido'=> $request['Apellido'],
                'Sexo'=> $request['SexoId'],
                'Telefono'=> $request['Telefono'],
                'Email'=> $request['Correo'],
                'NacionalidadId'=> $request['NacionalidadId'],
                'Enabled' => $request['Enabled']
            ]);
            //$residenteEdit->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
            DB::rollback();    
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
}
