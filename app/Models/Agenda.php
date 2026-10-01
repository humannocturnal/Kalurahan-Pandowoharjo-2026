<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'dukuh_id',
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    /**
     * Agenda dimiliki oleh satu dukuh.
     */
    public function dukuh()
    {
        return $this->belongsTo(Dukuh::class, 'dukuh_id');
    }

    /**
     * Satu agenda dapat memiliki banyak foto.
     */
    public function fotos()
    {
        return $this->hasMany(AgendaFoto::class, 'agenda_id');
    }

    /**
     * Satu agenda dapat memiliki realisasi kegiatan.
    */
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'agenda_id');
    }
}