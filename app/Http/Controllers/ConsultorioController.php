<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultorioController extends Controller
{
    public function index(Request $req)
    {
        try {
            if ($req->id) {
                $consultorio = Consultorio::findOrFail($req->id);
                Log::info('Consultorio encontrado para edición', ['consultorio_id' => $req->id]);
            } else {
                $consultorio = new Consultorio();
                Log::info('Creando nuevo consultorio');
            }

            return view('consultorio', compact('consultorio'));
        } catch (\Exception $e) {
            Log::error('Error al acceder a la vista de consultorio: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista de consultorio.');
        }
    }


    public function list()
    {
        // Obtener todos los doctores
        $consultorios = Consultorio::all();

        return view('consultorios', compact('consultorios' ));
    }

    public function listApi()
    {
        // Obtener todos los doctores
        $consultorios = Consultorio::all();

        return view('consultorios', compact('consultorios' ));
    }


    public function save(Request $req)
    {
        try {
            $consultorio = $req->id ? Consultorio::findOrFail($req->id) : new Consultorio();

            $consultorio->numero = $req->numero;
            $consultorio->save();

            Log::info('Consultorio guardado', ['consultorio_id' => $consultorio->id, 'numero' => $consultorio->numero]);

            return redirect()->route('consultorios')->with('success', 'Consultorio guardada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el consultorio: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al guardar el consultorio.');
        }
    }



    public function delete(Request $req)
    {
        try {
            $consultorio = Consultorio::findOrFail($req->id);
            $consultorio->delete();

            Log::info('Consultorio eliminado', ['consultorio_id' => $req->id]);

            return redirect()->route('consultorios')->with('success', 'Consultorio eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el consultorio: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al eliminar el consultorio.');
        }
    }

}
