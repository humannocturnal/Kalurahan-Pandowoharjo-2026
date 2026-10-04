<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Kegiatan;
use Carbon\Carbon;

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


        /*
        |--------------------------------------------------------------------------
        | FULLCALENDAR EVENTS
        |--------------------------------------------------------------------------
        */

        $calendarEvents = [];


        foreach ($calendarAgenda as $item) {

            $calendarEvents[] = [
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
                    'type' => 'Agenda',
                    'lokasi' => $item->lokasi,
                    'dukuh' => $item->dukuh
                        ? $item->dukuh->nama_dukuh
                        : null,
                ],
            ];
        }


        foreach ($calendarKegiatan as $item) {

            $calendarEvents[] = [
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
                    'type' => 'Kegiatan',
                    'lokasi' => $item->lokasi,
                    'dukuh' => $item->dukuh
                        ? $item->dukuh->nama_dukuh
                        : null,
                ],
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'home',
            compact(
                'agenda',
                'kegiatan',
                'calendarEvents'
            )
        );
    }
}