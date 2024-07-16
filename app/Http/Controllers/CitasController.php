<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\Consultorio;
use App\Models\Medicamento;
use App\Models\MedicamentosRecetados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id_doctor');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class, 'id_consultorio');
    }
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
        $medicamentos = Medicamento::all();
        $medicamentosRecetados = $req->id ? MedicamentosRecetados::where('id_cita', $cita->id)->get() : collect();

        return view('cita', compact('cita', 'doctores',  'consultorios', 'medicamentos','medicamentosRecetados'));
    }
    public function list()
    {
        $user = Auth::user();

        if ($user->rol == 'A') {
            $citas = Citas::all();
        }
        elseif ($user->rol == 'D') {
            $doctor = Doctor::where('idUsr', $user->id)->first();
            $id_especialidad = $doctor->id_especialidad;
            $citas = Citas::where('id_especialidades', $id_especialidad)
                ->get();
        }
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
        
        $medicamentos = $request->medicamentos;
        if ($request->medicamentos) {
            foreach ($request->medicamentos as $medicamentoJSON) {
                $medicamento = json_decode($medicamentoJSON, true);
                $medicamentoRecetado = new MedicamentosRecetados();
                $medicamentoRecetado->id_cita = $cita->id;
                $medicamentoRecetado->id_medicamento = $medicamento['id'];
                $medicamentoRecetado->cantidad = $medicamento['cantidad'];
                $medicamentoRecetado->unidad = $medicamento['unidad'];
                $medicamentoRecetado->cadaCuando = $medicamento['cadaCuando'];
                $medicamentoRecetado->cuantosDias = $medicamento['cuantosDias'];
                $medicamentoRecetado->save();
            }
        }

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
