<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        return view('home');
    }
}
