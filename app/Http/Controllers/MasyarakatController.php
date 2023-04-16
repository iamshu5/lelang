<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Models\HistoryLelang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MasyarakatController extends Controller
{
    public function index(Request $request) {
        $DataMasyarakat = Masyarakat::when(!empty($request->search_masyarakat), function($query) use($request) {
            $query->where('nama_masyarakat', 'like', '%'.$request->search_masyarakat.'%')
                    ->orWhere('username', 'like', '%'.$request->search_masyarakat.'%')
                    ->orWhere('telp', 'like', '%'.$request->search_masyarakat.'%');
        })->paginate('15');

        $user = Auth::user();
        return view('admin.dataMasyarakat', ['masyarakat' => $DataMasyarakat]);
    }

    public function tambah(Request $request) {
        $user = Auth::user();
        $masyarakat = new Masyarakat();
        $masyarakat->nama_masyarakat = $request->nama_masyarakat;
        $masyarakat->username = $request->username;
        $masyarakat->password = Hash::make($request->password);
        $masyarakat->telp = $request->telp;

        $this->validate($request, [
            'nama_masyarakat' => 'required|min:0|max:50',
            'username' => 'required|min:0|max:50',
            'password' => 'required|min:0|max:100',
            'telp' => 'required|min:0|max:20',
        ]);

        $check = Masyarakat::where('username', $request->username)->count() > 0;
        if($check) 
        {
            return redirect($user->levels->level . '/data/masyarakat')->with('alert', [
                'bg' => 'warning', 
                'message' => 'Username sudah tersedia!']);
        }

        $masyarakat->save();
        return redirect($user->levels->level . '/data/masyarakat')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil ditambahkan!'
        ]);
    }

    public function edit(Masyarakat $masyarakat, Request $request) {
        $user = Auth::user();
        $masyarakat->nama_masyarakat = $request->nama_masyarakat;
        $masyarakat->username = $request->username;
        $masyarakat->password = !empty($request->password) ? Hash::make($request->password) : $masyarakat->password;
        $masyarakat->telp = $request->telp;

        $masyarakat->save();
        return redirect($user->levels->level . '/data/masyarakat')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil diedit!']);
    }

    public function delete(Masyarakat $masyarakat) {
        $user = Auth::user();
        $masyarakat->delete();
        return redirect( $user->levels->level . '/data/masyarakat')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil dihapus!']);
    }

    /*
    |-----------------------
     BACKEND PENAWARAN
    |-----------------------
    */
    
    // display barang yang sedang dilelang mengambil dari tabel lelang dan status 
    public function indexPenawaran() {
        $waktu = strtotime('now');
        $tb_lelang = Lelang::where(DB::raw('UNIX_TIMESTAMP(tanggal_lelang)'), '<=', $waktu) // Jika Tanggal lelang dimulai sebelum hari ini, maka bisa display
            ->where(DB::raw('UNIX_TIMESTAMP(tanggal_lelang_selesai)'), '>=', $waktu) // Jika Tanggal lelang selesai lebih dari waktu yang ditentukan, maka tidak bisa bisa muncul
            ->where('status', 'Dibuka')->with('barang')->get(); // Tampilakn status yang DIBUKA
        return view('masyarakat.dashboard', compact('tb_lelang'));
    }

    public function detailPenawaran(Lelang $tb_lelang) {
        $barang = $tb_lelang->barang;
        return view('masyarakat.dataTawar', compact('tb_lelang', 'barang'));
    }

    public function tambahPenawaran(Lelang $tb_lelang, Request $request) {
        // Jika penawarannya kurang dari harga awal
        if($request->penawaran_harga < $tb_lelang->barang->harga_awal)
        {
            return redirect('masyarakat/data/penawaran/' . $tb_lelang->id_lelang)->with('alert', [
                'bg' => 'danger', 
                'message' => 'Harga yang ditawarkan masih kurang!'
            ]);
        }
        // Menambahkan Penawaran
        HistoryLelang::create([
            'id_lelang' => $tb_lelang->id_lelang,
            'id_masyarakat' => Auth::guard('masyarakat')->user()->id_masyarakat,
            'penawaran_harga' => $request->penawaran_harga,
            'id_barang' => $tb_lelang->id_barang,
            'tanggal_nawar' => date('Y-m-d'),
        ]);
        return redirect('masyarakat/data/penawaran/' . $tb_lelang->id_lelang)->with('alert', [ 
            'bg' => 'success', 
            'message' => 'Anda telah menambahkan penawaran!',
        ]);
    }
}