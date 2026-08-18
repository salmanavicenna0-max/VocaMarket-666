<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'type',
        'category',
        'name',
        'description',
        'price',
        'image_path',
        'is_active',
        'approval_status',
        'original_price',
        'discount_percentage',
        'sales_count',
        'rating',
        'reviews_count',
        'stock',
        'store_name',
        'store_location',
        'is_star',
        'is_promo',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'original_price' => 'integer',
            'is_active' => 'boolean',
            'is_star' => 'boolean',
            'is_promo' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    // -- Relationships --

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): ?ProductImage
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->orderBy('sort_order')->first();
    }



    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get thumbnail URL — backward compatible with image_path column.
     * Priority: product_images(is_primary) > product_images(first) > image_path > default
     */
    public function getThumbnailAttribute(): string
    {
        if ($img = $this->primaryImage()) {
            return asset('storage/' . $img->path);
        }

        if ($this->image_path) {
            return $this->image_path;
        }

        return asset('storage/products/default.png');
    }

    public function isJasa()
    {
        return in_array($this->category, ['DKV & Animasi', 'Pemasaran', 'PPLG', 'Akuntansi']) || $this->type === 'jasa';
    }
}
