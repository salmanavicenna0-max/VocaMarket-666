<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    use HasFactory;

    const STATUS_REQUESTED = 'requested';
    const STATUS_PROOF_SENT = 'proof_sent';
    const STATUS_DISPUTED = 'disputed';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';

    const STATUS_LABELS = [
        self::STATUS_REQUESTED => 'Dalam Peninjauan',
        self::STATUS_PROOF_SENT => 'Bukti Terkirim (Menunggu Konfirmasi Pembeli)',
        self::STATUS_DISPUTED => 'Bukti Disengketakan (Sengketa)',
        self::STATUS_CONFIRMED => 'Refund Selesai',
        self::STATUS_REJECTED => 'Refund Dibatalkan',
    ];

    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'reason',
        'proof_path',
        'admin_note',
        'transfer_reference',
        'dispute_reason',
        'rejection_reason',
        'handled_by',
        'proof_sent_at',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'proof_sent_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? (string) $this->status;
    }
}