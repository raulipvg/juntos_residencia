<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GastoMesController extends Controller
{
    public function Index(){
        return View('gastomes.gastomes');
    }
}
