<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MedicamentoController extends Controller
{
    public function index(Request $req)
    {
        try {
            $medicamento = $req->id ? Medicamento::findOrFail($req->id) : new Medicamento();
            Log::info('Acceso a vista de medicamento', ['medicamento_id' => $req->id]);
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
        try {
            if ($req->id) {
                $medicamento = Medicamento::findOrFail($req->id);
                $existingMedicamento = Medicamento::where('codigo', $req->codigo)
                                                ->where('id', '!=', $req->id)
                                                ->first();

                if ($existingMedicamento) {
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
            Log::info('Medicamento guardado', ['medicamento_id' => $medicamento->id]);
            return redirect()->route('medicamentos')->with('success', 'Medicamento guardado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar medicamento: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al guardar el medicamento.');
        }
    }



    public function delete(Request $req)
    {
        try {
            $medicamento = Medicamento::findOrFail($req->id);
            $medicamento->delete();
            Log::info('Medicamento eliminado', ['medicamento_id' => $medicamento->id]);

            return redirect()->route('medicamentos')->with('success', 'Medicamento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar medicamento: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al eliminar el medicamento.');
        }
    }
}

