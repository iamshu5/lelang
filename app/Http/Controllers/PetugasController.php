<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Levels;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request) {
        $petugas  = User::when(!empty($request->search_petugas), function($query) use($request){
                $query->where('nama_petugas', 'like', '%'.$request->search_petugas.'%')
                ->orWhere('username', 'like', '%'.$request->search_petugas.'%')
                ->orWhere('level', 'like', '%'.$request->search_petugas.'%');
        })->paginate(10);
        $levels = Levels::all();
        return view('admin.dataPetugas', ['petugas' => $petugas, 'levels' => $levels]);
    }

    // FUNCTION TAMBAH
    public function tambah(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'nama_petugas' => 'required',
            'username' => 'required',
            'password' => 'required',
            'id_level' => 'required',
        ]);
        // Validasi jika Nama Barang sudah ada.
        $check = User::where('username', $request->username)->count() > 0;
        if($check) {
            return redirect($user->levels->level . '/data/admin-petugas')->with('alert', [
                'bg' => 'warning', 
                'message' => 'Username sudah terdaftar!']);
        }
        $petugas = new User();
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->username = $request->username;
        $petugas->password = Hash::make($request->password);
        $petugas->id_level = $request->id_level;

        $petugas->save();
        return redirect($user->levels->level . '/data/admin-petugas')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil ditambah!']);
    }

    // FUNCTION EDIT
    public function edit(User $petugas, Request $request) {
        $user = Auth::user();
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->username = $request->username;
        $petugas->password = !empty($request->password) ? Hash::make($request->password) : $petugas->password;
        $petugas->id_level = $request->id_level;

        $petugas->save();
        return redirect($user->levels->level . '/data/admin-petugas')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil diedit!']);
    }

    // FUNCTION DELETE
    public function delete(User $petugas) {
        $user = Auth::user();
        $petugas->delete();
        return redirect($user->levels->level . '/data/admin-petugas')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil dihapus!']);
    }
}