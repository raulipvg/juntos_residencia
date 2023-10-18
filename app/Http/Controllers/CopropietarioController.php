<?php

namespace App\Http\Controllers;

use App\Models\Nacionalidad;
use App\Models\Copropietario;
use App\Models\TipoComite;
use App\Models\Propiedad;
use Illuminate\Http\Client\Request;

class CopropietarioController extends Controller
{
    public function Index(){
        $copropietarios = Copropietario::all();
        $tiposComite = TipoComite::select('Id', 'Nombre') -> get();
        $propiedades = Propiedad::select('Id', 'Numero') -> get();
        $nacionalidad = Nacionalidad::select('Id', 'Nombre') -> get();

        return View('copropietario.copropietario') -> with ([
            'Copropietarios' => $copropietarios,
            'TiposComite' => $tiposComite,
            'Propiedades' => $propiedades,
            'Nacionalidades' => $nacionalidad
        ]);

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
