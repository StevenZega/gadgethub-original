<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'user_id',
        'store_location',
        'bank_account',
        'qris_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}