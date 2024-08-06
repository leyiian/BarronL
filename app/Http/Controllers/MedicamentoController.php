<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\MedicamentosRecetados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MedicamentoController extends Controller
{
    public function index(Request $req)
    {
        try {
            $medicamento = $req->id ? Medicamento::findOrFail($req->id) : new Medicamento();
            $user = auth()->user();
            Log::info('Acceso a vista de medicamento', [
                'medicamento_id' => $req->id,
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'request_data' => $req->all()
            ]);
            return view('medicamento', compact('medicamento'));
        } catch (\Exception $e) {
            Log::error('Error al acceder a vista de medicamento: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista del medicamento.');
        }
    }


    public function list()
    {
        $medicamentos = Medicamento::all();

        return view('medicamentos', compact('medicamentos'));
    }

    public function save(Request $req)
    {
        $user = auth()->user();
        try {
            if ($req->id) {
                $medicamento = Medicamento::findOrFail($req->id);
                $existingMedicamento = Medicamento::where('codigo', $req->codigo)
                                                ->where('id', '!=', $req->id)
                                                ->first();

                if ($existingMedicamento) {
                    Log::warning('Conflicto de código de medicamento', [
                        'user_id' => $user ? $user->id : 'No autenticado',
                        'user_name' => $user ? $user->name : 'No autenticado',
                        'request_data' => $req->all(),
                        'existing_medicamento_id' => $existingMedicamento->id
                    ]);
                    return back()->with('error', 'El código del medicamento ya existe en otro registro.');
                }
                $medicamento->codigo = $req->codigo;
                $medicamento->descripcion = $req->descripcion;
                $medicamento->precio = $req->precio;
                $medicamento->existencia = $req->existencia;
                $medicamento->fecha_caducidad = $req->fecha_caducidad;
            } else {
                $medicamento = Medicamento::where('codigo', $req->codigo)->first();
                if ($medicamento) {
                    $medicamento->descripcion = $req->descripcion;
                    $medicamento->precio = $req->precio;
                    $medicamento->existencia += $req->existencia;
                    $medicamento->fecha_caducidad = $req->fecha_caducidad;
                } else {
                    $medicamento = new Medicamento();
                    $medicamento->codigo = $req->codigo;
                    $medicamento->descripcion = $req->descripcion;
                    $medicamento->precio = $req->precio;
                    $medicamento->existencia = $req->existencia;
                    $medicamento->fecha_caducidad = $req->fecha_caducidad;
                }
            }
            $medicamento->estado = Carbon::parse($req->fecha_caducidad)->isPast() ? false : true;
            $medicamento->save();
            Log::info('Medicamento guardado', [
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'medicamento_id' => $medicamento->id,
                'request_data' => $req->all()
            ]);
            return redirect()->route('medicamentos')->with('success', 'Medicamento guardado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar medicamento', [
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'error_message' => $e->getMessage(),
                'request_data' => $req->all()
            ]);
            return back()->with('error', 'Hubo un problema al guardar el medicamento.');
        }
    }


    public function obtenerMedicamentos(Request $request){
        $idCita = $request->input('id_cita');
        $medicamentos = MedicamentosRecetados::where('id_cita', $idCita)->get();
        return response()->json(['medicamentos' => $medicamentos]);
    }


    public function delete(Request $req)
    {
        $user = auth()->user();
        try {
            $medicamento = Medicamento::findOrFail($req->id);
            $medicamento->delete();
            Log::info('Medicamento eliminado', [
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'medicamento_id' => $medicamento->id,
                'request_data' => $req->all()
            ]);

            return redirect()->route('medicamentos')->with('success', 'Medicamento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar medicamento', [
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'error_message' => $e->getMessage(),
                'request_data' => $req->all()
            ]);
            return back()->with('error', 'Hubo un problema al eliminar el medicamento.');
        }
    }
}

