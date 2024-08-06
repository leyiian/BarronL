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
use Illuminate\Support\Facades\Log;

class CitasController extends Controller
{

    public function index(Request $req)
    {
        $logUser = auth()->user();
        try {
            $cita = $req->id ? Citas::findOrFail($req->id) : new Citas();
            $paciente = Paciente::find($cita->id_paciente);
            $cita->nombreCompletoPaciente = $paciente
                ? $paciente->nombre . ' ' . $paciente->apPat . ' ' . $paciente->apMat
                : 'Paciente no encontrado';
            if (!$paciente) {
                Log::warning('Paciente no encontrado', [
                    'id_paciente' => $cita->id_paciente,
                    'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                    'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
                ]);
            }
            $especialidad = Especialidad::find($cita->id_especialidades);
            $cita->nombreEspecialidad = $especialidad
                ? $especialidad->nombre
                : 'Especialidad no encontrada';
            if (!$especialidad) {
                Log::warning('Especialidad no encontrada', [
                    'id_especialidades' => $cita->id_especialidades,
                    'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                    'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
                ]);
            }
            $doctores = $especialidad ? Doctor::where('id_especialidad', $especialidad->id)->get() : collect();
            $consultorios = Consultorio::all();
            $medicamentos = Medicamento::where('estado', true)->get();
            $medicamentosRecetados = $req->id ? MedicamentosRecetados::with('medicamento')->where('id_cita', $cita->id)->get() : collect();
            Log::info('Acceso a vista de cita', [
                'cita_id' => $cita->id,
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
            ]);
            return view('cita', compact('cita', 'doctores', 'consultorios', 'medicamentos', 'medicamentosRecetados'));
        } catch (\Exception $e) {
            Log::error('Error al obtener datos en el método index de CitasController: ' . $e->getMessage(), [
                'request_data' => $req->all(),
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
            ]);
            return back()->with('error', 'Hubo un problema al obtener los datos de la cita.');
        }
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
        $logUser = auth()->user();
        try {
            // Encuentra o crea una nueva cita
            $cita = $request->id ? Citas::findOrFail($request->id) : new Citas();
            // Asigna los valores de la solicitud a la cita
            $cita->id_paciente = $request->id_paciente;
            $cita->fecha = $request->fecha;
            $cita->Observaciones = $request->Observaciones;
            $cita->estado = $request->estado;
            $cita->id_consultorio = $request->id_consultorio;
            $cita->id_doctor = $request->id_doctor;
            $cita->id_especialidades = $request->id_especialidades;
            $cita->save();
            // Procesa los medicamentos si existen
            if ($request->medicamentos) {
                foreach ($request->medicamentos as $medicamentoJSON) {
                    $medicamento = json_decode($medicamentoJSON, true);
                    $medicamentoRecetado = new MedicamentosRecetados();
                    $medicamentoRecetado->id_cita = $cita->id;
                    $medicamentoRecetado->id_medicamento = $medicamento['id'];
                    $medicamentoRecetado->cantidad = $medicamento['cantidad'];
                    $medicamentoRecetado->cadaCuando = $medicamento['cadaCuando'];
                    $medicamentoRecetado->cuantosDias = $medicamento['cuantosDias'];
                    $medicamentoRecetado->save();
                }
            }
            Log::info('Cita guardada', [
                'cita_id' => $cita->id,
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado',
                'request_data' => $request->all()
            ]);
            return redirect()->route('citas')->with('success', 'Cita guardada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar cita: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
            ]);
            return back()->with('error', 'Hubo un problema al guardar la cita.');
        }
    }


    public function listApi()
    {
        $citas = Citas::all();
        return $citas;
    }

    public function saveApi(Request $request)
    {
        try {
            $paciente = Paciente::where('idUsr', $request->idUsr)->first();
            if (!$paciente) {
                return response()->json(['message' => 'Paciente no encontrado'], 404);
            }

            $cita = $request->id ? Citas::findOrFail($request->id) : new Citas();
            $cita->id_paciente = $paciente->id;
            $cita->fecha = $request->fecha;
            $cita->Observaciones = $request->Observaciones;
            $cita->estado = $request->estado;
            $cita->id_consultorio = $request->id_consultorio;
            $cita->id_doctor = $request->id_doctor;
            $cita->id_especialidades = $request->id_especialidades;
            $cita->save();

            Log::info('Cita guardada a través de API', [
                'cita_id' => $cita->id,
                'paciente_id' => $paciente->id,
                'request_data' => $request->all()
            ]);

            return response()->json('Ok');
        } catch (\Exception $e) {
            Log::error('Error al guardar cita a través de API: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json(['message' => 'Hubo un problema al guardar la cita'], 500);
        }
    }


    public function delete(Request $req)
    {
        $logUser = auth()->user();
        try {
            $cita = Citas::findOrFail($req->id);
            $cita->delete();
            Log::info('Cita eliminada correctamente', [
                'cita_id' => $req->id,
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado'

            ]);
            return redirect()->route('citas')->with('success', 'Cita eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar cita: ' . $e->getMessage(), [
                'request_data' => $req->all(),
                'logUser_id' => $logUser ? $logUser->id : 'No autenticado',
                'logUser_name' => $logUser ? $logUser->name : 'No autenticado'
            ]);
            return redirect()->route('citas')->with('error', 'Hubo un problema al eliminar la cita.');
        }
    }

    public function eliminarMedicamentoRecetado(Request $req)
    {
        $medicamentoRecetado = MedicamentosRecetados::findOrFail($req->id);
        $medicamentoRecetado->delete();
        return response()->json(['success' => true]);
    }
}
