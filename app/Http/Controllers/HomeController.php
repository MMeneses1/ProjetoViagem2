<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibraryPro\Livewire\Concerns\WithMedia;


class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function render()
    {
        return view('home');
    }
}
