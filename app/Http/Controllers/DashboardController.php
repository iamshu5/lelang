<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lelang;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $jumlahPetugas      = DB::table('petugas')->count();
        $jumlahBarang       = DB::table('barang')->count();
        $jumlahMasyarakat   = DB::table('masyarakat')->count();
        $jumlahLelang       = DB::table('tb_lelang')->count();
        
        $waktu = strtotime('now');
        $tb_lelang = Lelang::where(DB::raw('UNIX_TIMESTAMP(tanggal_lelang)'), '<=', $waktu) // Jika Tanggal lelang dimulai sebelum hari ini, maka bisa display
            ->where(DB::raw('UNIX_TIMESTAMP(tanggal_lelang_selesai)'), '>=', $waktu) // Jika Tanggal lelang selesai lebih dari waktu yang ditentukan, maka tidak bisa bisa muncul
            ->where('status', 'Dibuka')->with('barang')->get(); // Tampilakn status yang DIBUKA
        $user = Auth::user();        
        return view($user->levels->level . '/dashboard', [
            'petugas' => $jumlahPetugas,
            'dbarang' => $jumlahBarang,
            'masyarakat' => $jumlahMasyarakat,
            'tb_lelang' => $jumlahLelang,
            'lelang' => $tb_lelang,
        ]);
    }

    public function detailPenawaran(Lelang $tb_lelang) {
        $barang = $tb_lelang->barang;
        return view('admin.dataPenawar', compact('tb_lelang', 'barang'));
    }
}
