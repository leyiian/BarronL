<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function index(Request $req)
    {
        if ($req->id) {
            $especialidad = Especialidad::find($req->id);
        } else {
            $especialidad = new Especialidad();
        }
        return view('especialidad', compact('especialidad'));
    }
    public function list()
    {
        $especialidades = Especialidad::all();
        return view('especialidades', compact('especialidades'));
    }

    public function listApi()
    {
        $especialidades = Especialidad::all();
        return $especialidades;
    }

    public function getApi(Request $req)
    {
        $especialidad = Especialidad::find($req->id);
        return $especialidad;
    }

    public function save(Request $req)
    {

        if ($req->id != 0) {
            $especialidad = Especialidad::find($req->id);
        } else {
            $especialidad = new Especialidad();
        }


        $especialidad->nombre = $req->nombre;
        $especialidad->estado = true;
        $especialidad->save();

        return redirect()->route('especialidades');
    }

    public function saveApi(Request $req)
    {

        if ($req->id != 0) {
            $especialidad = Especialidad::find($req->id);
        } else {
            $especialidad = new Especialidad();
        }


        $especialidad->nombre = $req->nombre;
        $especialidad->estado = true;
        $especialidad->save();

        return 'OK';
    }
    public function delete(Request $req)
    {
        $especialidad = Especialidad::find($req->id);
        $especialidad->delete();
        return redirect()->route('especialidades');
    }

    public function deleteApi(Request $req)
    {
        $especialidad = Especialidad::find($req->id);
        $especialidad->delete();
        return 'OK';
    }
}
