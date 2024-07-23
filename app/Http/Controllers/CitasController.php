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
        $doctores = $especialidad ? Doctor::where('id_especialidad', $especialidad->id)->get() : collect();
        $consultorios = Consultorio::all();
        $medicamentos = Medicamento::all();
        $medicamentosRecetados = $req->id ? MedicamentosRecetados::with('medicamento')->where('id_cita', $cita->id)->get() : collect();
        return view('cita', compact('cita', 'doctores', 'consultorios', 'medicamentos', 'medicamentosRecetados'));
    }

    public function indexApi(Request $req)
    {
        $paciente = Paciente::where('idUsr', $req->idUsr)->first();
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }
        $citas = Citas::where('id_paciente', $paciente->id)->get();
        return response()->json($citas);
    }


    public function list()
    {
        $user = Auth::user();
        $citas = [];

        if ($user->rol == 'A') {
            $citas = Citas::all();
        } elseif ($user->rol == 'D') {
            $doctor = Doctor::where('idUsr', $user->id)->first();

            if ($doctor) {
                $citas = Citas::where('id_doctor', $doctor->id)->get();
            } else {
                $citas = [];
            }
        }

        // Procesar citas para añadir información adicional
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

        //$medicamentos = $request->medicamentos;
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
        $doctores = Doctor::where('id_especialidad', $request->id_especialidades)->get();


        return redirect()->route('citas', compact('cita', 'doctores'));
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

    public function eliminarMedicamentoRecetado(Request $req)
    {
        $medicamentoRecetado = MedicamentosRecetados::findOrFail($req->id);
        $medicamentoRecetado->delete();
        return response()->json(['success' => true]);
    }
}
