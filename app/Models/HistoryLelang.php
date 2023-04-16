<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryLelang extends Model
{
    use HasFactory;
    protected $table = 'history_lelang';
    protected $primaryKey = 'id_history';
    protected $guarded = ['id_history'];
    protected $filltable = [
        'id_lelang',
        'id_masyarakat',
        'penawaran_harga',
        'id_barang',
    ];
    public $timestamps = false;

    public function lelang() {
        return $this->hasOne(Lelang::class, 'id_lelang', 'id_lelang');    
    }
    public function barang() {
        return $this->hasOne(Barang::class, 'id_barang', 'id_barang');    
    }
    public function masyarakat() {
        return $this->hasOne(Masyarakat::class, 'id_masyarakat', 'id_masyarakat');    
    }
}
