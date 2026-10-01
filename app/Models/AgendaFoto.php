<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaFoto extends Model
{
    use HasFactory;

    protected $table = 'agenda_foto';

    protected $fillable = [
        'agenda_id',
        'foto',
        'keterangan',
    ];

    /**
     * Foto dimiliki oleh satu agenda.
     */
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
}