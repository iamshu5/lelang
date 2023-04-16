<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index(Request $request) {
        $dilelang = Lelang::all();
        return view('welcome', compact('dilelang'));
    }
}
