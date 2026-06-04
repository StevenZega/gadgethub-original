<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promo extends Model
{
    protected $fillable = [
        'name',
        'code',
        'scope', 
        'category',    
        'product_id',       
        'discount_percent',
        'is_active',        
        'start_date',
        'end_date'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}