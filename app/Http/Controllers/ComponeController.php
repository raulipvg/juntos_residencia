<?php

namespace App\Http\Controllers;

use App\Models\Compone;
use App\Models\Comunidad;
use App\Models\Nacionalidad;
use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\RolComponeCoRe;
use Illuminate\Http\Request;

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
    }

    public function VerId(Request $request){
    
    }

    public function Editar(Request $request){
    
    }
}
