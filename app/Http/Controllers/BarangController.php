<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use App\Imports\BarangImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index(Request $request) {
        $DataBarang = Barang::when(!empty($request->search_barang), function($query) use($request){
                    $query->where('id_barang', 'like', '%'.$request->search_barang. '%')
                    ->orWhere('nama_barang', 'like', '%'.$request->search_barang.'%')
                    ->orWhere('tanggal', 'like', '%'.$request->search_barang.'%')
                    ->orWhere('harga_awal', 'like', '%'.$request->search_barang.'%')
                    ->orWhere('deskripsi_barang', 'like', '%'.$request->search_barang.'%');
        })->paginate(20);
        $DataLelang = Lelang::all();
        $user = Auth::user();
        return view($user->levels->level . '/dataBarang', ['barang' => $DataBarang, 'tb_lelang' => $DataLelang]);
    }

    public function tambah(Request $request) {
        $user = Auth::user();
        // Upload Gambar
        $this->validate($request, [
            'foto_barang' => 'required|mimes:jpeg,png,jpg',
            'nama_barang' => 'required|min:0|max:50',
            'tanggal' => 'required',
            'harga_awal' => 'required|min:0|max:50',
            'deskripsi_barang' => 'required|min:0|max:255',
            'stok' => 'required|min:0|max:50',
        ]);

        // Taruh File di assets/admin/image/barang
        $fileNames = $request->foto_barang->getClientOriginalName();
        $request->foto_barang->storeAs('assets/admin/image/barang', $fileNames);

        $barang = new Barang();
        $barang->foto_barang = $fileNames;
        $barang->nama_barang = $request->nama_barang;
        $barang->tanggal = $request->tanggal;
        $barang->harga_awal = $request->harga_awal;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        $barang->stok = $request->stok;

        // Mencegah nama barang ter double
        $check = Barang::where('nama_barang', $request->nama_barang)->count() > 0;
        if($check){
            return redirect('data/barang')->with('alert', [
                'bg' => 'warning', 
                'message' => 'Nama barang sudah diinput!']);
        }
        $barang->save();
        return redirect( $user->levels->level . '/data/barang')->with('alert', ['bg' => 'success', 'message' => 'Data berhasil ditambahkan!']);
    }

    public function edit(Barang $barang, Request $request) {
         // Pengecualian Edit Gambar
         if(!empty($request->foto_barang)) {
            @unlink(public_path("assets/admin/image/barang/{$barang->foto_barang}"));
            $fileNames = $request->foto_barang->getClientOriginalName();
            $request->foto_barang->storeAs('assets/admin/image/barang', $fileNames);
        }else{
            $fileNames = $barang->foto_barang;
        }

        $barang->foto_barang = $fileNames;
        $barang->nama_barang = $request->nama_barang;
        $barang->tanggal = $request->tanggal;
        $barang->harga_awal = $request->harga_awal;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        $barang->stok = $request->stok;

        $user = Auth::user();
        $barang->save();
        return redirect( $user->levels->level . '/data/barang')->with('alert', ['bg' => 'success', 'message' => 'Data berhasil diedit!']);
    }

    public function delete(Barang $barang) {
        $user = Auth::user();
        $barang->delete();
        return redirect( $user->levels->level . '/data/barang')->with('alert', [
            'bg' => 'success', 
            'message' => 'Data berhasil dihapus!']);
    }

    // Menampilkan data ke halaman detailbarang
    public function indexWelcome(Barang $barang) {
        $barang->id_barang;
        $barang->nama_barang;
        $barang->harga_awal;
        $barang->foto_barang;
        return view('detailBarang', compact('barang'));
    }

    // Import Excel
    public function importbarang(Request $request) {
        // Validasi Format Excel
        $this->validate($request, [
            'importbarang' => 'required|mimes:xlsx',
        ]);

        // Request dari view
        $barang  = $request->file('importbarang');
        $filename = $barang->getClientOriginalName(); // Guunakan nama asli file
        $barang->move('assets/admin/excel/import/', $filename);
        // Import dalam bentuk Excel
        Excel::import(new BarangImport, \public_path('assets/admin/excel/import/' . $filename));

        $user = Auth::user();
        return redirect($user->levels->level . '/data/barang')->with('alert', 
        ['bg' => 'success', 'message' => 'Data Excel Berhasil di Import!']);
    }
}
