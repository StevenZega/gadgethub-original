<?php

namespace App\Office; // Sesuaikan namespace jika berbeda, biasanya App\Models

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Tambahkan properti $fillable ini
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'subtotal'
    ];

    /**
     * Hubungan balik ke model Order (Opsional)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Hubungan ke model Product (Sangat berguna untuk menampilkan nama produk nanti)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}