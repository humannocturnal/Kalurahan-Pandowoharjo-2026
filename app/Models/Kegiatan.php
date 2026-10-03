<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'dukuh_id',
        'agenda_id',
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function dukuh()
    {
        return $this->belongsTo(
            Dukuh::class,
            'dukuh_id'
        );
    }

    public function agenda()
    {
        return $this->belongsTo(
            Agenda::class,
            'agenda_id'
        );
    }

    public function fotos()
    {
        return $this->hasMany(
            KegiatanFoto::class,
            'kegiatan_id'
        );
    }
}