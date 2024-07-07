<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Especialidad;

class DoctorController extends Controller
{
    public function index(Request $req)
    {
        $doctor = $req->id ? Doctor::findOrFail($req->id) : new Doctor();
        $especialidades = Especialidad::all();
        return view('doctor', compact('doctor', 'especialidades'));
    }

    public function list($idEspecialidad = null)
    {
        // Obtener todos los doctores
        $doctores = Doctor::all();

        $especialidadSeleccionada = $idEspecialidad ? Especialidad::find($idEspecialidad) : null;

        $especialidades = Especialidad::all();

        return view('doctores', compact('doctores', 'especialidadSeleccionada', 'especialidades'));
    }

    public function listApi($idEspecialidad = null)
    {
        // Obtener todos los doctores
        $doctores = Doctor::all();

        $especialidadSeleccionada = $idEspecialidad ? Especialidad::find($idEspecialidad) : null;

        $especialidades = Especialidad::all();

        return $doctores;
    }


    public function save(Request $req)
    {

        if ($req->id) {
            $doctor = Doctor::findOrFail($req->id);
            $user = User::findOrFail($doctor->idUsr);
        } else {
            $user = new User();
            $user->name = $req->nombre;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->rol = 'doctor';
            $user->save();
            $doctor = new Doctor();
            $doctor->idUsr = $user->id;
        }

        $doctor->nombre = $req->nombre;
        $doctor->apellido_paterno = $req->apellido_paterno;
        $doctor->apellido_materno = $req->apellido_materno;
        $doctor->id_especialidad = $req->id_especialidad;
        $doctor->cedula = $req->cedula;
        $doctor->telefono = $req->telefono;
        $doctor->save();

        return redirect()->route('doctores');
    }
    public function saveApi(Request $req)
    {

        $doctor = $req->id ? Doctor::findOrFail($req->id) : new Doctor();


        $doctor->nombre = $req->nombre;
        $doctor->apellido_paterno = $req->apellido_paterno;
        $doctor->apellido_materno = $req->apellido_materno;
        $doctor->id_especialidad = $req->id_especialidad;
        $doctor->cedula = $req->cedula;
        $doctor->telefono = $req->telefono;
        $doctor->save();

        return 'Ok';
    }

    public function delete(Request $req)
    {
        $doctor = Doctor::findOrFail($req->id);
        $doctor->delete();
        return redirect()->route('doctores');
    }

    public function deleteApi(Request $req)
    {
        $doctor = Doctor::findOrFail($req->id);
        $doctor->delete();
        return 'OK';
    }
}
