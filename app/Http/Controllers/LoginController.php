<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function registro(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rol = 'paciente';
        $user->save();
        return response()->json(['acceso' => 'Ok']);
    }

     public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array(
                'acceso' => "OK",
                'error' => "",
                'token' => $token,
                'idUsuario' => $user->id,
                'nombreUsuario' => $user->name
            );
            return json_encode($arr);
        } else {
            $arr = array(
                'acceso' => "", 'token' => "",
                'error' => "NO EXISTE EL USUARIO O CONTRASEÑA",
                'idUsuario' => 0,
                'nombreUsuario' => ''
            );
            return json_encode($arr);
        }
    }
}
