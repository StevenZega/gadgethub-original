<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos';

    protected $fillable = [
        'name',
        'code',
        'scope',
        'category',
        'product_id',
        'discount_percent',
        'quota',
        'is_active',
        'start_date',
        'end_date',
    ];

    /**
     * RELASI ELOPUENT: Promo menempel ke data Product
     * Ini yang bikin nama produk (seperti ROG Phone) bisa dipanggil lewat $promo->product->name
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}