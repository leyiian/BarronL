<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\Consultorio;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    public function index(Request $req)
    {
        $cita = $req->id ? Citas::findOrFail($req->id) : new Citas();

        // Obtener datos relacionados
        $paciente = Paciente::findOrFail($cita->id_paciente);
        $doctor = Doctor::findOrFail($cita->id_doctor);
        $especialidad = Especialidad::findOrFail($cita->id_especialidades);
        $consultorio = Consultorio::findOrFail($cita->id_consultorio);

        // Concatenar nombres completos
        $nombreCompletoPaciente = $paciente->nombre . ' ' . $paciente->apPat . ' ' . $paciente->apMat;
        $nombreCompletoDoctor = $doctor->nombre . ' ' . $doctor->apellido_paterno . ' ' . $doctor->apellido_materno;

        return view('cita', compact('cita', 'nombreCompletoPaciente', 'nombreCompletoDoctor', 'especialidad', 'consultorio'));
    }
    public function list($id_paciente = null)
    {
        $citas = Citas::all();
        $paciente = $id_paciente ? Paciente::find($id_paciente) : null;
        $nompaciente = $paciente ? $paciente->nombre . ' ' . $paciente->apPat . ' ' . $paciente->apMat : '';

        return view('citas', compact('citas', 'nompaciente'));
    }



    public function save(Request $request)
    {
        $cita = $request->id ? Citas::findOrFail($request->id) : new Citas();

        $cita->id_paciente = $request->id_paciente;
        $cita->fecha = $request->fecha;
        $cita->Observaciones = $request->Observaciones;
        $cita->estado = $request->estado;
        $cita->id_consultorio = $request->id_consultorio;
        $cita->id_doctor = $request->id_doctor;
        $cita->id_especialidades = $request->id_especialidades;

        $cita->save();

        return redirect()->route('cita');
    }

    public function listApi()
    {
        $citas = Citas::all();
        return $citas;
    }

    public function saveApi(Request $request)
    {
        $paciente = Paciente::where('idUsr', $request->idUsr)->first();

        $cita = $request->id ? Citas::findOrFail($request->id) : new Citas();

        $cita->id_paciente = $paciente->id;
        $cita->fecha = $request->fecha;
        $cita->Observaciones = $request->Observaciones;
        $cita->estado = $request->estado;
        $cita->id_consultorio = $request->id_consultorio;
        $cita->id_doctor = $request->id_doctor;
        $cita->id_especialidades = $request->id_especialidades;

        $cita->save();

        return 'Ok';
    }

    public function delete(Request $req)
    {
        $cita = Citas::findOrFail($req->id);
        $cita->delete();
        return redirect()->route('citas');
    }
}
