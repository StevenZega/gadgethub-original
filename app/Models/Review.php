<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // WAJIB: Mendaftarkan semua kolom agar diizinkan masuk ke database
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id', // <-- INI DIA YANG KETINGGALAN! Harus ada ini biar order_id kesimpan!
        'rating',
        'comment'
    ];

    /**
     * Relasi ke model Product (Opsional, jika dibutuhkan)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke model User (Opsional, jika dibutuhkan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}