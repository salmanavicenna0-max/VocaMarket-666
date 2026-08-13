<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id', 'type', 'category', 'name', 'description', 'price', 'image_path', 'is_active',
        'original_price', 'discount_percentage', 'sales_count', 'rating', 'reviews_count',
        'stock', 'store_name', 'store_location', 'is_star', 'is_promo'
    ];
}
