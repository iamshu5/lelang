<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lelang extends Model
{
    use HasFactory;
    protected $table = 'tb_lelang';
    protected $primaryKey = 'id_lelang';
    protected $guarded = ['id_lelang'];
    protected $filltable = [
        'id_barang',
        'tanggal_lelang',
        'harga_akhir',
        'id_masyarakat',
        'id_petugas',
        'status',
    ];
    public $timestamps = false;

    public function barang() {
        return $this->hasOne(Barang::class, 'id_barang', 'id_barang');
    }

    public function masyarakat() {
        return $this->hasOne(Masyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }

    public function petugas() {
        return $this->hasOne(User::class, 'id_petugas', 'id_petugas');
    }

    public function history_lelang() {
        return $this->hasMany(HistoryLelang::class, 'id_lelang', 'id_lelang');
    }

    // Method ini ditaruh di LelangController => editStatus.
    public function get_pemenang() {
        $pemenang = $this->history_lelang->sortByDesc('penawaran_harga'); // pilih harga yg tertinggi.
        return $pemenang->first();
    }
}