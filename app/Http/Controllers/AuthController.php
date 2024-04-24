<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Adicionando a importação da classe User
use Illuminate\Support\Facades\Hash; // Adicionando a importação da classe Hash

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email_or_username', 'password');

        $user = User::where('email', $credentials['email_or_username'])
                     ->orWhere('username', $credentials['email_or_username'])
                     ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect('/feed');
        }

        return redirect('/login')->with('error', 'E-mail, nome de usuário ou senha incorretos. Por favor, tente novamente.');
    }
}
