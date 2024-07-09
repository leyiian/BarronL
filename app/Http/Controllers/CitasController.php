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
        $paciente = Paciente::find($cita->id_paciente);

        $cita->nombreCompletoPaciente = $paciente
            ? $paciente->nombre . ' ' . $paciente->apPat . ' ' . $paciente->apMat
            : 'Paciente no encontrado';

        $especialidad = Especialidad::find($cita->id_especialidades);

        $cita->nombreEspecialidad = $especialidad
            ? $especialidad->nombre
            : 'Especialidad no encontrada';

        $doctores = Doctor::all();

        $consultorios = Consultorio::all();

        return view('cita', compact('cita', 'doctores',  'consultorios'));
    }
    public function list()
    {
        $citas = Citas::all();

        foreach ($citas as $cita) {
            $paciente = Paciente::find($cita->id_paciente);
            $doctor = Doctor::find($cita->id_doctor);
            $especialidad = Especialidad::find($cita->id_especialidades);
            $consultorio = Consultorio::find($cita->id_consultorio);

            $cita->nombreCompletoPaciente = $paciente
                ? $paciente->nombre . ' ' . $paciente->apPat . ' ' . $paciente->apMat
                : 'Paciente no encontrado';

            $cita->nombreCompletoDoctor = $doctor
                ? $doctor->nombre . ' ' . $doctor->apellido_paterno . ' ' . $doctor->apellido_materno
                : 'Doctor no encontrado / Asignado';

            $cita->nombreEspecialidad = $especialidad
                ? $especialidad->nombre
                : 'Especialidad no encontrada';

            $cita->numeroConsultorio = $consultorio
                ? $consultorio->numero
                : 'Consultorio no encontrado';
        }

        return view('citas', compact('citas'));
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

        return redirect()->route('citas');
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
