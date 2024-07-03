<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use Illuminate\Http\Request;

class ConsultorioController extends Controller
{
    public function index(Request $req)
    {
        $consultorio = $req->id ? Consultorio::findOrFail($req->id) : new Consultorio();

        return view('consultorio', compact('consultorio'));
    }

    public function list()
    {
        // Obtener todos los doctores
        $consultorios = Consultorio::all();

        return view('consultorios', compact('consultorios' ));
    }

    public function listApi()
    {
        // Obtener todos los doctores
        $consultorios = Consultorio::all();

        return view('consultorios', compact('consultorios' ));
    }


    public function save(Request $req)
    {

        $consultorio = $req->id ? Consultorio::findOrFail($req->id) : new Consultorio();

        $consultorio->numero = $req->numero;
        $consultorio->save();

        return redirect()->route('consultorios');
    }


    public function delete(Request $req)
    {
        $consultorio = Consultorio::findOrFail($req->id);
        $consultorio->delete();
        return redirect()->route('consultorios');
    }
}
