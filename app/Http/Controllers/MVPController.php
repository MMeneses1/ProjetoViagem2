<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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
            'sexo' => 'nullable|string',
            'biografia' => 'nullable|string',
            'telefone' => 'nullable|string',
            'pais' => 'nullable|string',
            'idioma' => 'nullable|string',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajuste o tamanho máximo conforme necessário
        ]);

        $fotoPerfilPath = null;

        if ($request->hasFile('foto_perfil')) {
            $image = $request->file('foto_perfil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/fotos_perfil', $imageName);
            $fotoPerfilPath = 'storage/fotos_perfil/' . $imageName;
        }

        $usuario = new User([
            'email' => $request->input('email'),
            'nome' => $request->input('nome'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'sexo' => $request->input('sexo'),
            'biografia' => $request->input('biografia'),
            'telefone' => $request->input('telefone'),
            'pais' => $request->input('pais'),
            'idioma' => $request->input('idioma'),
            'foto_perfil' => $fotoPerfilPath,
        ]);

        if ($usuario->save()) {
            return redirect()->route('login')->with('success', 'Registro realizado com sucesso!');
        } else {
            return back()->withInput()->with('error', 'Erro durante o registro. Tente novamente.');
        }
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('insta.perfil', compact('user'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/iniciar');
    }

    public function showProfileEditForm()
    {
        return view('insta.perfiledit', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:usuarios,username,' . Auth::id(),
        'sexo' => 'nullable|string',
        'telefone' => 'nullable|string',
        'biografia' => 'nullable|string', // Adicione a validação para a biografia
        'idioma' => 'nullable|string',    // Adicione a validação para o idioma
        'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    $user->username = $request->input('username');
    $user->sexo = $request->input('sexo');
    $user->telefone = $request->input('telefone');
    $user->biografia = $request->input('biografia'); // Atualize o campo de biografia
    $user->idioma = $request->input('idioma');       // Atualize o campo de idioma

    if ($request->hasFile('foto_perfil')) {
        $imagePath = $request->file('foto_perfil')->store('public/fotos_perfil');
        $fotoPerfilPath = str_replace('public/', 'storage/', $imagePath);

        if ($user->foto_perfil) {
            Storage::delete(str_replace('storage/', 'public/', $user->foto_perfil));
        }

        $user->foto_perfil = $fotoPerfilPath;
    }

    if ($user->save()) {
        return redirect()->route('perfil')->with('success', 'Perfil atualizado com sucesso!');
    } else {
        return back()->withInput()->with('error', 'Erro ao atualizar o perfil. Tente novamente.');
    }
}

}
