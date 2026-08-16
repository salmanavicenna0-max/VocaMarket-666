<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';
    const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'code_order',
        'user_id',
        'status',
        'subtotal',
        'discount',
        'total',
        'note',
        'whatsapp_link',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // -- Relationships --

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    // -- Helpers --

    /**
     * Generate unique order code: ESK-YYYYMMDD-0001
     */
    public static function generateCode(): string
    {
        $date = now()->format('Ymd');
        $prefix = "ESK-{$date}";

        $lastOrder = static::where('code_order', 'like', "{$prefix}-%")
            ->orderByDesc('code_order')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->code_order, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            self::STATUS_DITOLAK => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
