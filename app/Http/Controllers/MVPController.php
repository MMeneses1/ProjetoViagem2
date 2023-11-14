<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

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
        $rules = [
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
        ];

        $messages = [
            'email' => 'Por favor, informe um e-mail válido.',   
            'email.unique' => 'Este e-mail já está sendo utilizado.',
            'nome' => 'Por favor, informe o seu nome.',
            'usuario' => 'Por favor, informe um usuário.',
            'usuario.unique' => 'Este usuário já está sendo utilizado',
            'password.required' => 'Por favor, informe uma senha',
            'password.min' => 'A senha deve ter no mínimo 8 dígitos',
            'password.confirmed' => 'As senhas não são compatíveis.'
        ];

        $request->validate($rules, $messages);

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
    $followersCount = $user->followers()->count();
    $followingCount = $user->following()->count();
    $posts = Post::where('user_id', $user->id)->orderByDesc('created_at')->get();
    $noPosts = $posts->isEmpty(); // Verifique se não há postagens

    return view('insta.perfil', compact('user', 'posts', 'noPosts', 'followersCount', 'followingCount'));
}

public function showDados()
{
    $user = Auth::user();
    $posts = Post::where('user_id', $user->id)->orderByDesc('created_at')->get();
    $noPosts = $posts->isEmpty(); // Verifique se não há postagens

    return view('insta.perfilpessoal', compact('user', 'posts', 'noPosts'));
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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

public function showOtherUserProfile($username)
{
    $otherUser = User::where('username', $username)->first();

    if (!$otherUser) {
        // Usuário não encontrado
        return redirect()->route('feed')->with('error', 'Usuário não encontrado.');
    }

    $posts = Post::where('user_id', $otherUser->id)->orderByDesc('created_at')->get();

    return view('insta.perfil-outro', compact('otherUser', 'posts'));
}

public function pesquisar(Request $request)
{
    $query = $request->input('query');

    $resultados = User::where('nome', 'like', "%$query%")
                      ->orWhere('username', 'like', "%$query%")
                      ->get();

    return view('insta.pesquisa', compact('resultados', 'query'));
}

public function pesquisarAoDigitar(Request $request)
{
    $query = $request->input('query');

    $resultados = User::where('nome', 'like', "%$query%")
                      ->orWhere('username', 'like', "%$query%")
                      ->limit(5) // Limita o número de resultados retornados
                      ->get();

    return response()->json($resultados);
}


public function followUser($username)
{
    $userToFollow = User::where('username', $username)->first();

    if (!$userToFollow) {
        // Usuário não encontrado
        return redirect()->back()->with('error', 'Usuário não encontrado.');
    }

    auth()->user()->following()->attach($userToFollow);

    return redirect()->back()->with('success', 'Agora você está seguindo ' . $userToFollow->username);
}

public function unfollowUser($username)
{
    $userToUnfollow = User::where('username', $username)->first();

    if (!$userToUnfollow) {
        // Usuário não encontrado
        return redirect()->back()->with('error', 'Usuário não encontrado.');
    }

    auth()->user()->following()->detach($userToUnfollow);

    return redirect()->back()->with('success', 'Você não está mais seguindo ' . $userToUnfollow->username);
}

// Adicione este método
public function getFollowers()
{
    $user = auth()->user();
    $followers = $user->followers;

    return response()->json(['followers' => $followers]);
}

// Adicione este método
public function getFollowing()
{
    $user = auth()->user();
    $following = $user->following;

    return response()->json(['following' => $following]);
}


}


