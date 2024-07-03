<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index(Request $req)
    {
        $medicamento = $req->id ? Medicamento::findOrFail($req->id) : new Medicamento();

        return view('medicamento', compact('medicamento'));
    }

    public function list()
    {
        $medicamentos = Medicamento::all();

        return view('medicamentos', compact('medicamentos'));
    }

    public function save(Request $req)
    {
        $medicamento = $req->id ? Medicamento::findOrFail($req->id) : new Medicamento();

        $medicamento->codigo = $req->codigo;
        $medicamento->descripcion = $req->descripcion;
        $medicamento->precio = $req->precio;
        $medicamento->existencia = $req->existencia;
        $medicamento->fecha_caducidad = $req->fecha_caducidad;
        $medicamento->save();

        return redirect()->route('medicamentos');
    }

    public function delete(Request $req)
    {
        $medicamento = Medicamento::findOrFail($req->id);
        $medicamento->delete();
        return redirect()->route('medicamentos');
    }
}

