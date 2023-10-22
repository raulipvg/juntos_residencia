<?php

namespace App\Http\Controllers;

use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\Residente;
use App\Models\RolResidente;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class ResidenteController extends Controller
{
    public function Index(){
        $residentes = Residente::all();
        $personas = Persona::select('Id', 'Nombre', 'Apellido', 'RUT')->get();
        $propiedades = Propiedad::select('Id', 'Numero')->get();
        $roles = RolResidente::select('Id','Nombre')->get();
        $nacionalidades = Nacionalidad::select('Id','Nombre')->get();

        return View('residente.residente')->with([
            'Residentes' => $residentes,
            'Nacionalidades' => $nacionalidades,
            'Propiedades' => $propiedades,
            'Roles' => $roles
        ]);
    }
    public function Guardar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo    
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
        $request['Rut'] = strtolower($request['Rut']);
        
        try{
            $persona = New Persona();
            $persona->validate([
                'RUT' => $request['Rut'],
                'Nombre' => $request['Nombre'],
                'Apellido' => $request['Apellido'],
                'Sexo' => $request['SexoId'],
                'Telefono' => $request['Telefono'],
                'RolId' => $request['RolId'],
                'Enabled' => $request['Enabled'],
                'NacionalidadId' => $request['NacionalidadId']
            ]);

            $residente = new Residente();

            $residente->validate([
                'PersonaId' => 1,
                'PropiedadId' => $request['PropiedadId'],
                'RolId' => $request['RolId'],
                'FechaInicio' => $request['FechaInicio'],
                'FechaFin' => $request['FechaFin']              
            ]);

            //$residente->fill($request);
            // Usamos transacción para asegurar la integridad de los datos
            DB::beginTransaction();
            $persona = Persona::create([
                'RUT' => $request['Rut'],
                'Nombre' => $request['Nombre'],
                'Apellido' => $request['Apellido'],
                'Sexo' => $request['SexoId'],
                'Telefono' => $request['Telefono'],
                'RolId' => $request['RolId'],
                'Enabled' => $request['Enabled'],
                'NacionalidadId' => $request['NacionalidadId']
            ]);        

            $residente = Residente::create([
                'PersonaId' => $persona->Id, 
                'PropiedadId' => $request['PropiedadId'],
                'RolId' => $request['RolId'],
                'FechaInicio' => $request['FechaInicio'],
                'FechaFin' => $request['FechaFin'] 
            ]);
            //$persona->residentes()->save($residente);
            //$residente->save();
            // Confirmar la transacción
            DB::commit();
            //$residente->save(); 
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

            $residente= Residente::find($request);
            return response()->json([
                'success' => true,
                'data' => [
                            $residente,
                            $residente->persona,
                        ]
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
        $request['Rut'] = strtolower($request['Rut']);

         try{
            $residenteEdit = Residente::find($request['Id']);

            $persona = New Persona();
            $persona->validate([
                'Id' => $residenteEdit->persona->Id,
                'RUT' => $request['Rut'],
                'Nombre' => $request['Nombre'],
                'Apellido' => $request['Apellido'],
                'Sexo' => $request['SexoId'],
                'Telefono' => $request['Telefono'],
                'RolId' => $request['RolId'],
                'Enabled' => $request['Enabled'],
                'NacionalidadId' => $request['NacionalidadId']
            ]);

            $residente = new Residente();

            $residente->validate([
                'PersonaId' => $residenteEdit->persona->Id,
                'PropiedadId' => $request['PropiedadId'],
                'RolId' => $request['RolId'],
                'FechaInicio' => $request['FechaInicio'],
                'FechaFin' => $request['FechaFin']              
            ]);

            //$residente->fill($request);
            // Usamos transacción para asegurar la integridad de los datos
            DB::beginTransaction();

            $residenteEdit->update([
                'PropiedadId' => $request['PropiedadId'],
                'RolId' => $request['RolId'],
                'FechaInicio' => $request['FechaInicio'],
                'FechaFin' => $request['FechaFin'] 
            ]);
            //$userEdit->Username
            //$residenteEdit->fill($request);
            $personaEdit= $residenteEdit->persona;
            $personaEdit->update([
                'RUT' => $request['Rut'],
                'Nombre' => $request['Nombre'],
                'Apellido' => $request['Apellido'],
                'Sexo' => $request['SexoId'],
                'Telefono' => $request['Telefono'],
                'RolId' => $request['RolId'],
                'Enabled' => $request['Enabled'],
                'NacionalidadId' => $request['NacionalidadId']
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
