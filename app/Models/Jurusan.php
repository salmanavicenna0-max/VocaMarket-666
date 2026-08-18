<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'code_jurusan',
        'name_jurusan',
        'slug',
        'description',
        'logo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // -- Relationships --

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_jurusan')
            ->withTimestamps();
    }
}
