<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | AGENDA MENDATANG
        |--------------------------------------------------------------------------
        */

        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->whereDate('tanggal', '>=', Carbon::today())
            ->where('status', 'direncanakan')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN TERBARU
        |--------------------------------------------------------------------------
        */

        $kegiatan = Kegiatan::with(['dukuh', 'fotos'])
            ->whereDate('tanggal', '<=', Carbon::today())
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | BATAS BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        $startOfMonth = Carbon::now()
            ->startOfMonth()
            ->toDateString();

        $endOfMonth = Carbon::now()
            ->endOfMonth()
            ->toDateString();


        /*
        |--------------------------------------------------------------------------
        | AGENDA BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        $calendarAgenda = Agenda::with('dukuh')
            ->whereBetween(
                'tanggal',
                [
                    $startOfMonth,
                    $endOfMonth
                ]
            )
            ->orderBy('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN BULAN BERJALAN
        |--------------------------------------------------------------------------
        */

        $calendarKegiatan = Kegiatan::with('dukuh')
            ->whereBetween(
                'tanggal',
                [
                    $startOfMonth,
                    $endOfMonth
                ]
            )
            ->orderBy('tanggal')
            ->get();


        return view(
            'home',
            compact(
                'agenda',
                'kegiatan',
                
            )
        );
    }

    public function calendarEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $events = [];


        /*
        |--------------------------------------------------------------------------
        | AGENDA
        |--------------------------------------------------------------------------
        */

        $agenda = Agenda::with('dukuh')
            ->whereDate('tanggal', '>=', $start)
            ->whereDate('tanggal', '<', $end)
            ->get();


        foreach ($agenda as $item) {

            $events[] = [
                'id' => 'agenda-' . $item->id,

                'title' => $item->judul,

                'start' => $item->tanggal->format('Y-m-d'),

                'url' => route(
                    'agenda.show',
                    $item->id
                ),

                'backgroundColor' => '#16a34a',

                'borderColor' => '#16a34a',

                'textColor' => '#ffffff',

                'extendedProps' => [
                    'type' => 'agenda',

                    'lokasi' => $item->lokasi,

                    'dukuh' => $item->dukuh
                        ? $item->dukuh->nama_dukuh
                        : '-',
                ],
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN
        |--------------------------------------------------------------------------
        */

        $kegiatan = Kegiatan::with('dukuh')
            ->whereDate('tanggal', '>=', $start)
            ->whereDate('tanggal', '<', $end)
            ->get();


        foreach ($kegiatan as $item) {

            $events[] = [
                'id' => 'kegiatan-' . $item->id,

                'title' => $item->judul,

                'start' => $item->tanggal->format('Y-m-d'),

                'url' => route(
                    'kegiatan.show',
                    $item->id
                ),

                'backgroundColor' => '#f97316',

                'borderColor' => '#f97316',

                'textColor' => '#ffffff',

                'extendedProps' => [
                    'type' => 'kegiatan',

                    'lokasi' => $item->lokasi,

                    'dukuh' => $item->dukuh
                        ? $item->dukuh->nama_dukuh
                        : '-',
                ],
            ];
        }


        return response()->json($events);
    }
}