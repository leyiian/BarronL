<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PacienteController extends Controller
{
    public function index(Request $req)
    {
        try {
            $paciente = $req->id ? Paciente::findOrFail($req->id) : new Paciente();
            $user = auth()->user();
            Log::info('Acceso a vista de paciente', [
                'paciente_id' => $req->id,
                'user_id' => $user ? $user->id : 'No autenticado',
                'user_name' => $user ? $user->name : 'No autenticado',
                'request_data' => $req->all()
            ]);
            return view('paciente', compact('paciente'));
        } catch (\Exception $e) {
            Log::error('Error al acceder a vista de paciente: ' . $e->getMessage(), ['request_data' => $req->all()]);
            return back()->with('error', 'Hubo un problema al acceder a la vista.');
        }
    }

    public function list()
    {
        $pacientes = Paciente::all();

        return view('pacientes', compact('pacientes'));
    }

    public function listApi()
    {
        $pacientes = Paciente::all();

        return $pacientes;
    }

    public function getApi(Request $req)
    {
        $paciente = Paciente::find($req->id);
        return $paciente;
    }

    public function save(Request $req)
    {
        $userlog = auth()->user();
        try {
            if ($req->id) {
                $paciente = Paciente::findOrFail($req->id);
                $user = User::findOrFail($paciente->idUsr);
                $user->name = $req->nombre . ' ' . $req->apPat . ' ' . $req->apMat;
                if ($req->filled('email')) {
                    $user->email = $req->email;
                }
                if ($req->filled('password')) {
                    $user->password = Hash::make($req->password);
                }
                $user->save();
            } else {
                $user = new User();
                $user->name = $req->nombre . ' ' . $req->apPat . ' ' . $req->apMat;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                $user->rol = 'P'; // Asumiendo que 'P' es el rol para pacientes
                $user->save();

                $paciente = new Paciente();
                $paciente->idUsr = $user->id;
            }

            $paciente->nombre = $req->nombre;
            $paciente->apPat = $req->apPat;
            $paciente->apMat = $req->apMat;
            $paciente->telefono = $req->telefono;
            $paciente->save();
            Log::info('Paciente guardado exitosamente', [
                'paciente_id' => $req->id,
                'user_id' => $userlog ? $userlog->id : 'No autenticado',
                'user_name' => $userlog ? $userlog->name : 'No autenticado',
                'request_data' => $req->all()
            ]);
            return redirect()->route('pacientes')->with('success', 'Paciente guardado correctamente.');;
        } catch (\Exception $e) {
            Log::error('Error al guardar paciente', [
                'user_id' => $userlog ? $userlog->id : 'No autenticado',
                'user_name' => $userlog ? $userlog->name : 'No autenticado',
                'error_message' => $e->getMessage(),
                'request_data' => $req->all()
            ]);
            return back()->with('error', 'Hubo un problema al guardar el paciente.');
        }
    }

    public function saveApi(Request $req)
    {

        $user = new User();
        $user->name = $req->nombre . ' ' . $req->apPat . ' ' . $req->apMat;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->rol = 'P';
        $user->save();

        $paciente = new Paciente();
        $paciente->nombre = $req->nombre;
        $paciente->apPat = $req->apPat;
        $paciente->apMat = $req->apMat;
        $paciente->telefono = $req->telefono;
        $paciente->idUsr = $user->id;
        $paciente->save();

        return 'Ok';
    }

    public function delete(Request $req)
    {
        $userlog = auth()->user();
        try {
            $paciente = Paciente::findOrFail($req->id);
            $user = User::findOrFail($paciente->idUsr);
            $paciente->delete();
            Log::info('Paciente eliminado exitosamente', [
                'paciente_id' => $req->id,
                'user_id' => $userlog ? $userlog->id : 'No autenticado',
                'user_name' => $userlog ? $userlog->name : 'No autenticado',
                'request_data' => $req->all()
            ]);
            $user->delete();
            Log::info('Usuario asociado al paciente eliminado', ['user_id' => $user->id]);
            return redirect()->route('pacientes')->with('success', 'Paciente eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar paciente', [
                'user_id' => $userlog ? $userlog->id : 'No autenticado',
                'user_name' => $userlog ? $userlog->name : 'No autenticado',
                'error_message' => $e->getMessage(),
                'request_data' => $req->all()
            ]);
            return back()->with('error', 'Hubo un problema al eliminar el paciente.');
        }
    }

    public function deleteApi(Request $req)
    {
        $paciente = Paciente::findOrFail($req->id);
        $paciente->delete();
        return 'OK';
    }
}
