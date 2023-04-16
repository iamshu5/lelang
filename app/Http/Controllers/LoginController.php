<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function userLogin() {
        if(Auth::check()) {
            return redirect('admin/dashboard');
        }
        return view('login');
    }

    public function logProses(Request $request) {
        $petugas = User::where('username', $request->username)->first();
        
        if($petugas == NULL || !Hash::check($request->password, $petugas->password)) {
            return redirect('authpetugas/login')->with('alert', [
                'bg' => 'danger', 
                'message' => 'Terjadi Kesalahan: Username dan Password tidak terdaftar!']);
        }
        Auth::login($petugas);
        return redirect($petugas->levels->level . '/dashboard');
    }

    public function userLogout() {
        Auth::logout();
        return redirect('/authpetugas/login')->with('alert', ['bg' => 'success', 'message' => 'Anda telah Logout!']);
    }

    // LOGIN MASYARAKAT
    public function masyarakatLogin() {
        if(Auth::guard('masyarakat')->check()) {
            return redirect('masyarakat/dashboard');
        }
        return view('loginMasyarakat');
    }
    
    public function masyarakatLogout() {
        Auth::guard('masyarakat')->logout();
        return redirect('masyarakat/login')->with('alert', ['bg' => 'success', 
            'message' => 'Anda telah Logout!'
        ]);
    }

    public function logProsess(Request $request) {
        $loginMasyarakat = Masyarakat::where('username', $request->username)->first(); 
        if($loginMasyarakat == NULL || !Hash::check($request->password, $loginMasyarakat->password)) {
            return redirect('masyarakat/login')->with('alert' ,['bg' => 'danger', 
            'message' => 'Terjadi Kesalahan: Username atau password tidak terdaftar'
            ]);
        }else{
            Auth::guard('masyarakat')->login($loginMasyarakat);
            return redirect('masyarakat/dashboard');
        }
    }
}