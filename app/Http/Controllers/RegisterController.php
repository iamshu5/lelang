<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(Request $request) {
        $DataRegister = Masyarakat::when(!empty($request->search_register), function($query) use($request) {
            $query->where('nama_register', 'like', '%'.$request->searhc_register)
            ->orWhere('username', 'like', '%'.$request->search_register.'%')
            ->orWhere('telp', 'like', '%'.$request->search_register.'%');
        })->paginate(5);
        return view('register', ['masyarakat' => $DataRegister]);
    }

    public function tambah(Request $request) {
        // Validasi Form Input
        $this->validate($request, [
            'nama_masyarakat' => 'required|min:0|max:50',
            'username' => 'required|min:0|max:50',
            'password' => 'required|min:0|max:100',
            'telp' => 'required|min:0|max:20',
        ]);

        // Validasi Jika username sudah digunakan
        $check = Masyarakat::where('username', $request->username)->count() > 0;
        if($check) {
            return redirect('/register')->with('alert', [
                'bg' => 'warning', 
                'message' => 'Username sudah tersedia!']);
        }

        $register = new Masyarakat();
        $register->nama_masyarakat = $request->nama_masyarakat;
        $register->username = $request->username;
        $register->password = Hash::make($request->password);
        $register->telp = $request->telp;

        $register->save();
        return redirect('masyarakat/login')->with('alert', ['bg' => 'success', 'message' => 'Register Berhasil!']);
    }
}