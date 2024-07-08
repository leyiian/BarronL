<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    public function list()
    {
        $citas = Citas::all();
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

        return redirect()->route('cita');
    }

    public function listApi()
    {
        $citas = Citas::all();
        return $citas;
    }

    public function saveApi(Request $request)
    {

        if ($request->id != 0) {
            $cita = Citas::find($request->id);
        } else {
            $cita = new Citas();
        }

        $cita->id_paciente = $request->id_paciente;
        $cita->fecha = $request->fecha;
        $cita->Observaciones = $request->Observaciones;
        $cita->estado = $request->estado;
        $cita->id_consultorio = $request->id_consultorio;
        $cita->id_doctor = $request->id_doctor;
        $cita->id_especialidades = $request->id_especialidades;

        $cita->save();

        return 'Ok';
    }
}
