<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    // FIX: Sudah ditambahkan 'scope' dan 'category' agar bisa di-edit dan di-save
    protected $fillable = [
        'code',
        'name',
        'discount_percent',
        'scope',
        'category',
        'product_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    // Mengubah tipe string database menjadi objek Carbon otomatis
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Fungsi Pintar untuk memeriksa apakah promo masih valid saat ini
    public function isValidNow()
    {
        $today = Carbon::today();
        return $this->is_active && ($today->between($this->start_date, $this->end_date));
    }
}