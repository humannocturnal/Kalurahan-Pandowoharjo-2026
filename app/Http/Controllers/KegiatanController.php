<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    /**
     * Menampilkan seluruh kegiatan.
     */
    public function index()
    {
        $kegiatan = Kegiatan::with([
                'dukuh',
                'fotos',
            ])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view(
            'kegiatan.index',
            compact('kegiatan')
        );
    }

    /**
     * Menampilkan detail kegiatan.
     */
    public function show($id)
    {
        $kegiatan = Kegiatan::with([
                'dukuh',
                'agenda',
                'fotos',
            ])
            ->findOrFail($id);

        return view(
            'kegiatan.show',
            compact('kegiatan')
        );
    }
}