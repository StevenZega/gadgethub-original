<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperWarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'admin_id',
        'message',
        'is_read',
    ];

    // Relasi ke produk yang diperingatkan
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke admin yang diberi peringatan
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}