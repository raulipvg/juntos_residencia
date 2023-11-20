<?php

namespace App\Http\Controllers;

use App\Models\Compone;
use App\Models\Comunidad;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\RolComponeCoRe;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponeController extends Controller
{
    public function Index(Request $request){

        if($request->input('c') != null){
            $comunidadId = $request->input('c');
            $componen = Compone::join('Propiedad','Compone.PropiedadId','=','Propiedad.Id')
                                ->where('Propiedad.ComunidadId', $comunidadId)
                                ->get();
            $personas = Compone::select('Persona.Id', 'Persona.RUT', 'Persona.Nombre', 'Persona.Apellido', 'Persona.Sexo', 'Persona.Telefono', 'Persona.Email', 'Persona.Enabled')
                                ->join('Propiedad','Compone.PropiedadId', '=', 'Propiedad.Id')
                                ->join('Persona', 'Compone.PersonaId', '=', 'Persona.Id')
                                ->where('Propiedad.ComunidadId',$comunidadId)
                                ->distinct()
                                ->get();
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
                'Propiedades' => $propiedades,
                'comunidadId' => $comunidadId
            ]);
        }
        else{
            $comunidadId = 12; //este sería por rol de usuario
        }
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
            'Propiedades' => $propiedades,
            'comunidadId' => $comunidadId
        ]);
    }

    public function Guardar(Request $request){
        //Crea Persona y Compone, requiere usar transacción (ver controlador ResidenteController anterior)
        $request = $request->input('data');
        // Accede a los atributos del modelo    
        $request['FechaInicio']= Carbon::now();
        $request['FechaFin']= null;
        $request['Enabled']= 1;
        try{

            if($request['RolId']== 1){
                $countPropietario = Compone::where('PropiedadId','=', $request['PropiedadId'])
                                        ->where('RolComponeCoReId','=', 1)
                                        ->where('Enabled','=', 1)
                                        ->count();
                $countArrendatario=0;
            
            }elseif($request['RolId']== 2){
                $countArrendatario = Compone::where('PropiedadId','=', $request['PropiedadId'])
                                        ->where('RolComponeCoReId','=', 2)
                                        ->where('Enabled','=', 1)
                                        ->count();
                $countPropietario =0;
            }else{
                $countArrendatario = 0;
                $countPropietario = 0;
            }   

            if($countPropietario == 0){
                if($countArrendatario == 0){

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
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya existe Residente Arrendatario']);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe Propietario Activo']);
            }   

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function Guardar2(Request $request){
        //Crea Persona y Compone, requiere usar transacción (ver controlador ResidenteController anterior)
        $request = $request->input('data');
        // Accede a los atributos del modelo    
        $request['FechaInicio']= Carbon::now();
        $request['Enabled']= 1;
        try{
           
            if($request['RolComponeCoReId']== 1){
                $countPropietario = Compone::where('PropiedadId','=', $request['PropiedadId'])
                                        ->where('RolComponeCoReId','=', 1)
                                        ->where('Enabled','=', 1)
                                        ->count();
                $countArrendatario=0;
            
            }elseif($request['RolComponeCoReId']== 2){
                $countArrendatario = Compone::where('PropiedadId','=', $request['PropiedadId'])
                                        ->where('RolComponeCoReId','=', 2)
                                        ->where('Enabled','=', 1)
                                        ->count();
                $countPropietario =0;
            }else{
                $countArrendatario = 0;
                $countPropietario = 0;
            }     

            if($countPropietario == 0){
                if($countArrendatario == 0){
                    $compone = Compone::create([
                        'PersonaId' => $request['PersonaId'],
                        'PropiedadId'=> $request['PropiedadId'],
                        'RolComponeCoReId'=> $request['RolComponeCoReId'],
                        'FechaInicio'=> $request['FechaInicio'],
                        'Enabled'=> $request['Enabled'],
                    ]);
                    $compone->save();
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Modelo recibido y procesado']);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Ya existe Residente Arrendatario']);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe Propietario Activo']);
            }   
            
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function VerId(Request $request){
        $request = $request->input('data');

        try{
            $compone = Compone::select('Compone.Id','Comunidad.Nombre as Comunidad','Compone.PersonaId', 'Propiedad.Numero as Propiedad','RolComponeCoRe.Nombre as Rol','FechaInicio','FechaFin','Compone.Enabled')
            ->where('Compone.PersonaId','=',$request)
            ->join('Propiedad', 'Propiedad.Id', '=', 'Compone.PropiedadId')
            ->join('Comunidad', 'Comunidad.Id', '=', 'Propiedad.ComunidadId')
            ->join('RolComponeCoRe', 'RolComponeCoRe.Id', '=', 'Compone.RolComponeCoReId')->get();
            return response()->json([
                'success' => true,
                'data' => $compone,
                'persona' => $request]);

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

    public function VerPorPropiedadId(Request $request){
        $request = $request->input('data');

        $compone = Compone::select('Persona.RUT','Persona.Nombre','Persona.Apellido','RolComponeCoRe.Nombre as Rol','Compone.FechaInicio','Compone.FechaFin','Compone.Enabled','Compone.Id')
                            ->where('Compone.PropiedadId',$request)
                            ->join('Persona', 'Persona.Id', '=','Compone.PersonaId')
                            ->join('RolComponeCoRe', 'RolComponeCoRe.Id', '=','Compone.RolComponeCoReId')
                            ->get();            

        return response()->json([
            'success' => true,
            'data' => $compone
        ]);
    }

    //Ver Comunidad disponible para una PersonaId determinada
    public function VerComunidadDisponible(Request $request){
    
        $request = $request->input('data');

        $PersonaId =$request;

        $comunidades = Comunidad::select('Comunidad.Id', 'Comunidad.Nombre')
                            ->where('Comunidad.Enabled', 1)
                            ->get();
        $persona = Persona::select('Nombre','Apellido')
                            ->where('Id',$PersonaId)
                            ->first();
      
        /* $propiedades = Propiedad::select('Comunidad.Id','Comunidad.Nombre')
                            ->where('Compone.PersonaId',$PersonaId)
                            ->join('Comunidad','Comunidad.Id','=','Propiedad.ComunidadId')
                            ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                            ->distinct()
                            ->get();
        */
        return response()->json([
            'success' => true,
            'data' => $comunidades,
            'persona'=> $persona

        ]);

    }
    //Ver personas disponible para asignar un residente, la persona no tiene que ya componer la residencia
    public function VerPersonaDisponible(Request $request){
        $request = $request->input('data');

        $PropiedadId =$request;

        $personas = Persona::select('Persona.Id', 'Persona.Nombre', 'Persona.Apellido')
                            ->whereNotIn('Persona.Id', function ($query) use ($PropiedadId) {
                                $query->select('Compone.PersonaId')
                                    ->from('Compone')
                                    ->where('Compone.PropiedadId', $PropiedadId);
                            })
                            ->get();
        $roles = RolComponeCoRe::select('Id','Nombre')
                            ->get();

        return response()->json([
                                'success' => true,
                                'data' => $personas,
                                'roles'=> $roles
                            ]);
                            
    }

    public function CambioEstado(Request $request){
        $request = $request->input('data');

        try{
            $componeEdit = Compone::find($request);
            DB::beginTransaction();
            $componeEdit->update([
                'Enabled' => ($componeEdit['Enabled'] == 1)? 2: 1,
                'FechaFin' => Carbon::now() 
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
