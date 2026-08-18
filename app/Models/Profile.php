<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'foto',
        'class',
        'kelas',
        'no_telp',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nis_nip',
        'nama_toko',
        'deskripsi_toko',
        'banner_toko',
    ];

    // -- Relationships --

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
