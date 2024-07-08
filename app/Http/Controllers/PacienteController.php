<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    public function index(Request $req)
    {
        $paciente = $req->id ? Paciente::findOrFail($req->id) : new Paciente();

        return view('paciente', compact('paciente'));
    }

    public function list()
    {
        $pacientes = Paciente::all();

        return view('pacientes', compact('pacientes'));
    }

    public function listApi()
    {
        $pacientes = Paciente::all();

        return $pacientes;
    }

    public function getApi(Request $req)
    {
        $paciente = Paciente::find($req->id);
        return $paciente;
    }

    public function save(Request $req)
    {
        $paciente = $req->id ? Paciente::findOrFail($req->id) : new Paciente();

        $paciente->nombre = $req->nombre;
        $paciente->apPat = $req->apPat;
        $paciente->apMat = $req->apMat;
        $paciente->telefono = $req->telefono;
        $paciente->save();

        return redirect()->route('pacientes');
    }

    public function saveApi(Request $req)
    {

        $user = new User();
        $user->name = $req->nombre . ' ' . $req->apPat . ' ' . $req->apMat;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->rol = 'paciente';
        $user->save();


        $paciente = new Paciente();
        $paciente->nombre = $req->nombre;
        $paciente->apPat = $req->apPat;
        $paciente->apMat = $req->apMat;
        $paciente->telefono = $req->telefono;
        $paciente->idUsr = $user->id;
        $paciente->save();

        return 'Ok';
    }

    public function delete(Request $req)
    {
        $paciente = Paciente::findOrFail($req->id);
        $paciente->delete();
        return redirect()->route('pacientes');
    }

    public function deleteApi(Request $req)
    {
        $paciente = Paciente::findOrFail($req->id);
        $paciente->delete();
        return 'OK';
    }
}
