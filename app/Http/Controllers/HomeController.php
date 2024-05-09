<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $user = backpack_auth()->user();
        return view('home', compact('user'));
    }
}
