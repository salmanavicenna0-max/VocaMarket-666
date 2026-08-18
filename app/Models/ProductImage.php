<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // -- Relationships --

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // -- Accessors --

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function getIsVideoAttribute(): bool
    {
        $ext = strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
        return in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'm4v']);
    }
}
