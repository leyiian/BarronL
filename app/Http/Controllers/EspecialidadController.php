<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Log;

class EspecialidadController extends Controller
{
    public function index(Request $req)
    {
        try {
            if ($req->id) {
                $especialidad = Especialidad::findOrFail($req->id);
                Log::info('Especialidad encontrada para edición', ['especialidad_id' => $req->id]);
            } else {
                $especialidad = new Especialidad();
                Log::info('Creando nueva especialidad');
            }

            return view('especialidad', compact('especialidad'));
        } catch (\Exception $e) {
            Log::error('Error al acceder a la vista de especialidad: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista de especialidad.');
        }
    }

    public function list()
    {
        $especialidades = Especialidad::all();
        return view('especialidades', compact('especialidades'));
    }

    public function listApi()
    {
        $especialidades = Especialidad::all();
        return $especialidades;
    }

    public function getApi(Request $req)
    {
        $especialidad = Especialidad::find($req->id);
        return $especialidad;
    }

    public function save(Request $req)
    {
        try {
            if ($req->id != 0) {
                $especialidad = Especialidad::findOrFail($req->id);
                Log::info('Especialidad encontrada para actualización', ['especialidad_id' => $req->id]);
            } else {
                $especialidad = new Especialidad();
                Log::info('Creando nueva especialidad');
            }

            $especialidad->nombre = $req->nombre;
            $especialidad->estado = true;
            $especialidad->save();

            Log::info('Especialidad guardada', ['especialidad_id' => $especialidad->id]);

            return redirect()->route('especialidades')->with('success', 'Especialidad guardada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar la especialidad: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al guardar la especialidad.');
        }
    }

    public function saveApi(Request $req)
    {

        if ($req->id != 0) {
            $especialidad = Especialidad::find($req->id);
        } else {
            $especialidad = new Especialidad();
        }


        $especialidad->nombre = $req->nombre;
        $especialidad->estado = true;
        $especialidad->save();

        return 'OK';
    }

    public function delete(Request $req)
    {
        try {
            $especialidad = Especialidad::findOrFail($req->id);
            $especialidad->delete();
            Log::info('Especialidad eliminada', ['especialidad_id' => $req->id]);
            return redirect()->route('especialidades')->with('success', 'Especialidad eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la especialidad: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al eliminar la especialidad.');
        }
    }

    public function deleteApi(Request $req)
    {
        $especialidad = Especialidad::find($req->id);
        $especialidad->delete();
        return 'OK';
    }
}
