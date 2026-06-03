<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'nama_promo',
        'kode_promo',
        'jenis_cakupan',
        'diskon',
        'status',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
}