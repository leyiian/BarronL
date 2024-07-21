<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Log;


class DoctorController extends Controller
{
    public function index(Request $req)
    {
        try {
            $doctor = $req->id ? Doctor::findOrFail($req->id) : new Doctor();
            $user = $req->id ? User::findOrFail($doctor->idUsr) : null;
            $especialidades = Especialidad::all();
            Log::info('Acceso a vista de doctor', ['doctor_id' => $req->id, 'user_id' => $user ? $user->id : null]);

            return view('doctor', compact('doctor', 'especialidades', 'user'));

        } catch (\Exception $e) {
            Log::error('Error al acceder a vista de doctor: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista.');
        }
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
    public function getApi(Request $req)
    {
        $doctor = Doctor::find($req->id);
        return $doctor;
    }

    public function save(Request $req)
    {
        try {
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

                Log::info('Doctor actualizado', ['doctor_id' => $doctor->id, 'user_id' => $user->id]);
            } else {
                $user = new User();
                $user->name = $req->nombre .' '. $req->apellido_paterno .' '. $req->apellido_materno;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                $user->rol = 'D';
                $user->save();

                $doctor = new Doctor();
                $doctor->idUsr = $user->id;

                Log::info('Nuevo doctor creado', ['user_id' => $user->id]);
            }

            $doctor->nombre = $req->nombre;
            $doctor->apellido_paterno = $req->apellido_paterno;
            $doctor->apellido_materno = $req->apellido_materno;
            $doctor->id_especialidad = $req->id_especialidad;
            $doctor->cedula = $req->cedula;
            $doctor->telefono = $req->telefono;
            $doctor->save();

            Log::info('Datos del doctor guardados', ['doctor_id' => $doctor->id]);

            return redirect()->route('doctores')->with('success', 'Doctor agregado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el doctor: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al guardar el doctor.');
        }
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
        try {
            $doctor = Doctor::findOrFail($req->id);
            $user = User::findOrFail($doctor->idUsr);
            $doctor->delete();
            Log::info('Doctor eliminado', ['doctor_id' => $req->id]);
            $user->delete();
            Log::info('Usuario asociado al doctor eliminado', ['user_id' => $user->id]);
            return redirect()->route('doctores')->with('success', 'Doctor eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el doctor: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al eliminar el doctor.');
        }
    }

    public function deleteApi(Request $req)
    {
        $doctor = Doctor::findOrFail($req->id);
        $doctor->delete();
        return 'OK';
    }
}
