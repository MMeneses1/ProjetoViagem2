<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileController extends Component
{
    public function show()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return view('perfil', compact('user', 'posts'));

    }
}
