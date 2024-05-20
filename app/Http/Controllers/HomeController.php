<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\Component;


class HomeController extends Component
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
