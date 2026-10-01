<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanFoto extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_foto';

    protected $fillable = [
        'kegiatan_id',
        'foto',
        'keterangan',
    ];

    /**
     * Foto dimiliki oleh satu kegiatan.
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}