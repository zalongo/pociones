<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponser;
use Auth;

class AuthController extends Controller
{

    use ApiResponser;

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Usuario y/o Contraseña Incorrectos', 401);
        }

        $user = auth()->user();
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->success(null, "Chao Pesca'o");
    }
}