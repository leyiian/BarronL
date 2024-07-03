<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $req)
    {
        $material = $req->id ? Material::findOrFail($req->id) : new Material();

        return view('material', compact('material'));
    }

    public function list()
    {
        $materiales = Material::all();

        return view('materiales', compact('materiales'));
    }

    public function save(Request $req)
    {
        $material = $req->id ? Material::findOrFail($req->id) : new Material();

        $material->codigo = $req->codigo;
        $material->descripcion = $req->descripcion;
        $material->precio = $req->precio;
        $material->existencia = $req->existencia;
        $material->fecha_caducidad = $req->fecha_caducidad;
        $material->save();

        return redirect()->route('materiales');
    }

    public function delete(Request $req)
    {
        $material = Material::findOrFail($req->id);
        $material->delete();

        return redirect()->route('materiales');
    }
}
