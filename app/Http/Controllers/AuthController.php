<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            return redirect('/feed');
        }

        // Autenticação falhou
        return redirect('/login')->with('error', 'E-mail ou senha incorretos. Por favor, tente novamente.');
    }
}

