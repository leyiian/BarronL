<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    public function index(Request $req)
    {
        try {
            $material = $req->id ? Material::findOrFail($req->id) : new Material();
            Log::info('Acceso a vista de material', ['material_id' => $req->id]);
            return view('material', compact('material'));
        } catch (\Exception $e) {
            Log::error('Error al acceder a vista de material: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista del material.');
        }
    }


    public function list()
    {
        $materiales = Material::all();

        return view('materiales', compact('materiales'));
    }

    public function save(Request $req)
    {
        try {
            $material = $req->id ? Material::findOrFail($req->id) : new Material();
            $material->codigo = $req->codigo;
            $material->descripcion = $req->descripcion;
            $material->precio = $req->precio;
            $material->existencia = $req->existencia;
            $material->fecha_caducidad = $req->fecha_caducidad;
            $material->save();

            Log::info('Material guardado exitosamente', ['material_id' => $material->id]);

            return redirect()->route('materiales')->with('success', 'Material guardada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el material: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al guardar el material.');
        }
    }


    public function delete(Request $req)
    {
        try {
            $material = Material::findOrFail($req->id);
            $material->delete();
            Log::info('Material eliminado exitosamente', ['material_id' => $material->id]);
            return redirect()->route('materiales')->with('success', 'Material eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el material: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al eliminar el material.');
        }
    }

}
