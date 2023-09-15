<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MVPController extends Controller
{
    public function showLoginForm()
    {
        return view('insta.login');
    }

    public function showRegisterForm()
    {
        return view('insta.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:usuarios',
            'nome' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = new User([
            'email' => $request->input('email'),
            'nome' => $request->input('nome'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($usuario->save()) {
            return redirect()->route('login')->with('success', 'Registro realizado com sucesso!');
        } else {
            return back()->withInput()->with('error', 'Erro durante o registro. Tente novamente.');
        }
    }
}
