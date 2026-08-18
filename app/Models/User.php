<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nis',
        'email',
        'password',
        'role',
        'verification_seller',
        'seller_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verification_seller' => 'boolean',
        ];
    }

    // -- Relationships --

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function salesOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // -- Helpers --

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->verification_seller && $this->seller_status === 'approved';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
}
