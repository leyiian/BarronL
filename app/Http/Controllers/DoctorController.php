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
        $user = $req->id ? User::findOrFail($doctor->idUsr) : null;
        $especialidades = Especialidad::all();
        return view('doctor', compact('doctor', 'especialidades', 'user'));
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
            $user->name = $req->nombre . ' ' . $req->apellido_paterno . ' ' . $req->apellido_materno;
            if ($req->filled('email')) {
                $user->email = $req->email;
            }
            if ($req->filled('password')) {
                $user->password = Hash::make($req->password);
            }
            $user->save();
        } else {
            $user = new User();
            $user->name = $req->nombre .' '. $req->apellido_paterno .' '. $req->apellido_materno;
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
        $user = User::findOrFail($doctor->idUsr);
        $doctor->delete();
        $user->delete();
        return redirect()->route('doctores');
    }

    public function deleteApi(Request $req)
    {
        $doctor = Doctor::findOrFail($req->id);
        $doctor->delete();
        return 'OK';
    }
}
