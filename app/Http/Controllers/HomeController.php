<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Kegiatan;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 5 agenda dengan tanggal paling dekat.
        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->whereDate('tanggal', '>=', Carbon::today())
            ->where('status', 'direncanakan')
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->limit(5)
            ->get();

        // Mengambil 5 kegiatan terbaru.
        $kegiatan = Kegiatan::with(['dukuh', 'fotos'])
            ->whereDate('tanggal', '<=', Carbon::today())
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('agenda', 'kegiatan'));
    }
}