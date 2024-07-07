<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;

class CitasController extends Controller
{


    public function list()
    {
        $citas = Citas::all();
        return $citas;
    }
    public function save(Request $req)
    {

        if ($req->id != 0) {
            $cita = Citas::find($req->id);
        } else {
            $cita = new Citas();
        }
        $cita->id_paciente = $req->id_paciente;
        $cita->fecha = $req->fecha;
        $cita->Observaciones = $req->Observaciones;
        $cita->estado = $req->estado;
        $cita->id_consultorio = $req->id_consultorio;
        $cita->id_doctor = $req->id_doctor;
        $cita->id_especialidades = $req->id_especialidades;
        $cita->save();

        return 'Ok';
    }
    public function listApi()
    {
        $citas = Citas::all();
        return $citas;
    }
    public function saveApi(Request $req)
    {

        if ($req->id != 0) {
            $cita = Citas::find($req->id);
        } else {
            $cita = new Citas();
        }
        $cita->id_paciente = $req->id_paciente;
        $cita->fecha = $req->fecha;
        $cita->Observaciones = $req->Observaciones;
        $cita->estado = $req->estado;
        $cita->id_consultorio = $req->id_consultorio;
        $cita->id_doctor = $req->id_doctor;
        $cita->id_especialidades = $req->id_especialidades;
        $cita->save();

        return 'Ok';
    }
}
