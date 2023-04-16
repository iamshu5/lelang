<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $guarded = ['id_barang'];
    protected $filltable = [
        'nama_barang', 
        'tanggal', 
        'harga_awal', 
        'deskripsi_barang',
        'stok'
    ];
    public $timestamps = false;

    public function tb_lelang() {
        return $this->hasOne(Lelang::class, 'id_barang', 'id_barang');
    }
    public function history_lelang() {
        return $this->hasOne(HistoryLelang::class, 'id_history', 'id_history');
    }
    public function masyarakat() {
        return $this->hasOne(Masyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }
}