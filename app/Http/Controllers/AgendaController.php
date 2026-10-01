<?php

namespace App\Http\Controllers;

use App\Models\Agenda;

class AgendaController extends Controller
{
    // Daftar seluruh agenda
    public function index()
    {
        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->orderBy('tanggal', 'asc')
            ->paginate(9);

        return view('agenda.index', compact('agenda'));
    }

    // Detail agenda
    public function show($id)
    {
        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->findOrFail($id);

        return view('agenda.show', compact('agenda'));
    }

    // Pencarian agenda berdasarkan bulan dan tahun
    public function searchByMonth($month, $year)
    {
        abort_unless(
            filter_var($month, FILTER_VALIDATE_INT) !== false
            && (int) $month >= 1
            && (int) $month <= 12
            && filter_var($year, FILTER_VALIDATE_INT) !== false
            && (int) $year >= 2000
            && (int) $year <= 2100,
            404
        );

        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'asc')
            ->paginate(9);

        return view('agenda.index', compact('agenda'));
    }
}