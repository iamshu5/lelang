<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use App\Exports\LelangExport;
use App\Models\HistoryLelang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LelangController extends Controller
{
    public function index(Request $request) {
        $DataLelang = Lelang::when(!empty($request->status), function($query) use($request) {
            $query->where('status', $request->status);
        })->when(!empty($request->tanggal_lelang), function($query) use($request) {
            $query->where(DB::raw('DATE(tanggal_lelang)'), $request->tanggal_lelang);
        })->when(!empty($request->tanggal_lelang_selesai), function($query) use($request) {  
            $query->where(DB::raw('DATE(tanggal_lelang_selesai)'), $request->tanggal_lelang_selesai);
        })->get();

        $databarang = Barang::where('stok', '>', 0)->get(); // Jika stok nya kosong
        return view('petugas.lelang.dataLelang', ['lelang' => $DataLelang, 'barang' => $databarang]);
    }

    public function tambah(Request $request) {
        $this->validate($request, [
            'id_barang' => 'required',
            'status' => 'required',
            'tanggal_lelang' => 'required',
            'tanggal_lelang_selesai' => 'required',
        ]);

        $user = Auth::user();
        $lelang = new Lelang();
        $lelang->id_barang = $request->id_barang;
        $lelang->tanggal_lelang = $request->tanggal_lelang;
        $lelang->tanggal_lelang_selesai = $request->tanggal_lelang_selesai;
        $lelang->id_petugas = $user->id_petugas;
        $lelang->status = $request->status;
        $lelang->save();
        return redirect($user->levels->level . '/data/lelang')->with('alert', ['bg' => 'success', 'message' => 'Data berhasil ditambahkan'] );
    }

    public function edit(Request $request, Lelang $tb_lelang) {
        // dd($tb_lelang);
        $user = Auth::user();
        // $tb_lelang->id_barang = $request->id_barang;
        $tb_lelang->status = $request->status;
        $tb_lelang->tanggal_lelang = $request->tanggal_lelang;
        $tb_lelang->tanggal_lelang_selesai = $request->tanggal_lelang_selesai;
        $tb_lelang->save();
        return redirect($user->levels->level . '/data/lelang')->with( [
            'bg' => 'success',
            'message' => 'Data berhasil diedit',
        ]);
    }

    // Auth Petugas mengedit STATUS LELANG
    public function editStatus($status, Lelang $tb_lelang) {   // Jika status ditutup dan sudah ada penawar, dan mengklik tombol selesai maka bisa menentukan pemenang berdasarkan harga tertinggi
        if($status == 'ditutup' && is_null($tb_lelang->id_masyarakat)) {
            $pemenang = $tb_lelang->get_pemenang(); 
            $tb_lelang->harga_akhir = $pemenang->penawaran_harga;
            $tb_lelang->id_masyarakat = $pemenang->id_masyarakat;
        }
        
        $tb_lelang->status = ucfirst($status); // ditentukan status yang dipilih dibuka ataupun ditutup
        $tb_lelang->save();
        $user = Auth::user();
        return redirect($user->levels->level . '/data/lelang')->with( [ 
            'bg' => 'success',
            'message' => 'Lelang telah ditutup',
        ]);
    }

    public function delete(Lelang $tb_lelang) {
        HistoryLelang::where('id_lelang', $tb_lelang->id_lelang)->delete(); // Untuk bisa Edit/Delete ber relasi dengan History Lelang
        $tb_lelang->delete();
        $user = Auth::user();
        return redirect($user->levels->level . '/data/lelang')->with( [
            'bg' => 'success',
            'message' => 'Data berhasil diedit',
        ]);
    }

    public function historyMasyarakat(Request $request) {
        $userMasy = Auth::guard('masyarakat')->user();
        $history_masyarakat = HistoryLelang::where('id_masyarakat', $userMasy->id_masyarakat)->get();
       return view('masyarakat.dataHistoryLelang', compact('history_masyarakat')); 
    }

    // History Lelang untuk Halaman Petugas
    public function history() {
        $history_lelang = HistoryLelang::all();
        $tb_lelang = Lelang::all();
        return view('petugas.lelang.historyLelang', compact('history_lelang', 'tb_lelang'));
    }

    // Detail List dan Barang 
    public function detailPenawaran(Lelang $tb_lelang) {
        $barang = $tb_lelang->barang;
        return view('petugas.lelang.dataPenawar', compact('tb_lelang', 'barang'));
    }

    public function exportpdf() {
        $lelang = Lelang::all();
        view()->share('lelang', $lelang);
        
        $pdf = PDF::loadview('petugas.lelang.exportpdf');
        return $pdf->download('laporan-lelang.pdf');
    }

    public function exportexcel() {
        return Excel::download(new LelangExport, 'data-lelang.xlsx');
    }
}