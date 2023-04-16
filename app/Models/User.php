<?php

namespace App\Models;

use App\Models\Levels;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    protected $guarded = ['id_petugas'];
    protected $filltable = [
        'username', 
        'password', 
        'level',
        'nama_petugas',
        'id_level',
    ];
    public $timestamps = false;

    // Relasi dengan table levels
    public function levels() {
        return $this->hasOne(Levels::class, 'id_level', 'id_level');
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
