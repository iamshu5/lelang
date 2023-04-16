<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable; // Class Import Excel
use Maatwebsite\Excel\Concerns\SkipsFailures; // Agar data tidak terduplikat
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Agar data tidak terduplikat
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Menggunakan Variable
use Maatwebsite\Excel\Concerns\WithValidation; // Validasi jika format tidak sesuai

class BarangImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Barang([
            'foto_barang' => $row['foto_barang'],
            'nama_barang' => $row['nama_barang'],
            'tanggal' => $row['tanggal'],
            'harga_awal' => $row['harga_awal'],
            'deskripsi_barang' => $row['deskripsi_barang'],
            'stok' => $row['stok'],
        ]);
    }

    public function rules(): array {
        return [
            'foto_barang' => 'required',
            'nama_barang' => 'required|unique:barang',
            'tanggal' => 'required',
            'harga_awal' => 'required',
            'deskripsi_barang' => 'required',
            'stok' => 'required',
        ];
    }

}
