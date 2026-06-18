<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'invoice_number', 
        'receiver_name', 
        'phone', 
        'address', 
        'notes', 
        'subtotal', 
        'discount', 
        'total', 
        'status',
        'payment_proof',
    ];

    /**
     * Hubungan ke model OrderItem (One to Many)
     * Ini fungsi yang sebelumnya hilang dan menyebabkan error
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Hubungan ke model User (Opsional, tapi akan berguna ke depannya)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}