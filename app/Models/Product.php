<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'brand',
        'ram',
        'storage',
        'battery_capacity',
        'processor',
        'rear_camera',
        'screen_size',
        'os',
        'vga',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function warnings()
    {
        return $this->hasMany(DeveloperWarning::class, 'product_id');
    }
}