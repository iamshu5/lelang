<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $primaryKey = 'id_masyarakat';
    protected $guarded = ['id_masyarkat'];
    protected $filltable = [
        'nama_masyarakat', 
        'username', 
        'password',
        'telp'
    ];
    public $timestamps = false;
}