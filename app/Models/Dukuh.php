<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dukuh extends Model
{
    use HasFactory;

    protected $table = 'dukuh';

    protected $fillable = [
        'nama_dukuh',
        'nama_kepala_dukuh',
        'alamat',
    ];

    /**
     * Satu dukuh memiliki banyak agenda.
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'dukuh_id');
    }

    /**
     * Satu dukuh memiliki banyak kegiatan.
     */
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'dukuh_id');
    }
}