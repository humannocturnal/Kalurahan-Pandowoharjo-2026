<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dukuh;
use Illuminate\Http\Request;
use App\Models\Kegiatan;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $selectedYear = (int) $request->get(
            'year',
            now()->year
        );

        $selectedMonth = $request->get('month', 'all');


        // Validasi sederhana bulan.
        if (
            $selectedMonth !== 'all' &&
            (
                !is_numeric($selectedMonth) ||
                (int) $selectedMonth < 1 ||
                (int) $selectedMonth > 12
            )
        ) {
            $selectedMonth = 'all';
        }


        /*
        |--------------------------------------------------------------------------
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        |
        | Mengambil tahun yang memang terdapat pada data agenda.
        |
        */

        $years = Agenda::query()
            ->selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn ($year) => (int) $year);


        // Supaya tahun sekarang tetap tersedia
        // walaupun belum mempunyai agenda.
        if (!$years->contains(now()->year)) {
            $years->push(now()->year);
        }

        $years = $years
            ->unique()
            ->sortDesc()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | DATA DUKUH
        |--------------------------------------------------------------------------
        */

        $dukuh = Dukuh::query()
            ->orderBy('nama_dukuh')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | STACKED BAR CHART
        |--------------------------------------------------------------------------
        |
        | Menghitung jumlah agenda per dukuh
        | untuk masing-masing bulan pada tahun terpilih.
        |
        */

        $stackedRaw = Agenda::query()
            ->selectRaw('dukuh_id, MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', $selectedYear)
            ->groupBy(
                'dukuh_id',
                'bulan'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA STACKED BAR
        |--------------------------------------------------------------------------
        */

        $stackedDatasets = [];


        foreach ($dukuh as $item) {

            $monthlyData = [];

            for ($month = 1; $month <= 12; $month++) {

                $total = $stackedRaw
                    ->where('dukuh_id', $item->id)
                    ->where('bulan', $month)
                    ->sum('total');

                $monthlyData[] = (int) $total;
            }


            $stackedDatasets[] = [
                'label' => $item->nama_dukuh,
                'data' => $monthlyData,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PIE CHART
        |--------------------------------------------------------------------------
        |
        | Menghitung total agenda setiap dukuh.
        |
        | Jika month = all:
        | seluruh agenda pada tahun dipilih.
        |
        | Jika month = angka:
        | hanya agenda pada bulan tersebut.
        |
        */

        $pieQuery = Agenda::query()
            ->selectRaw('dukuh_id, COUNT(*) as total')
            ->whereYear('tanggal', $selectedYear);


        if ($selectedMonth !== 'all') {

            $pieQuery->whereMonth(
                'tanggal',
                (int) $selectedMonth
            );
        }


        $pieRaw = $pieQuery
            ->groupBy('dukuh_id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA PIE
        |--------------------------------------------------------------------------
        */

        $pieLabels = [];
        $pieData = [];


        foreach ($dukuh as $item) {

            $total = (int) $pieRaw
                ->where('dukuh_id', $item->id)
                ->sum('total');


            // Dukuh dengan 0 agenda tidak perlu
            // menjadi potongan pie.
            if ($total > 0) {

                $pieLabels[] = $item->nama_dukuh;
                $pieData[] = $total;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalAgenda = Agenda::query()
            ->whereYear('tanggal', $selectedYear)
            ->when(
                $selectedMonth !== 'all',
                fn ($query) =>
                    $query->whereMonth(
                        'tanggal',
                        (int) $selectedMonth
                    )
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | STACKED BAR KEGIATAN
        |--------------------------------------------------------------------------
        */

        $kegiatanStackedRaw = Kegiatan::query()
            ->selectRaw('dukuh_id, MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', $selectedYear)
            ->groupBy(
                'dukuh_id',
                'bulan'
            )
            ->get();


        $kegiatanStackedDatasets = [];


        foreach ($dukuh as $item) {

            $monthlyData = [];

            for ($month = 1; $month <= 12; $month++) {

                $total = $kegiatanStackedRaw
                    ->where('dukuh_id', $item->id)
                    ->where('bulan', $month)
                    ->sum('total');

                $monthlyData[] = (int) $total;
            }


            $kegiatanStackedDatasets[] = [
                'label' => $item->nama_dukuh,
                'data' => $monthlyData,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PIE CHART KEGIATAN
        |--------------------------------------------------------------------------
        */

        $kegiatanPieQuery = Kegiatan::query()
            ->selectRaw('dukuh_id, COUNT(*) as total')
            ->whereYear('tanggal', $selectedYear);


        if ($selectedMonth !== 'all') {

            $kegiatanPieQuery->whereMonth(
                'tanggal',
                (int) $selectedMonth
            );
        }


        $kegiatanPieRaw = $kegiatanPieQuery
            ->groupBy('dukuh_id')
            ->get();


        $kegiatanPieLabels = [];
        $kegiatanPieData = [];


        foreach ($dukuh as $item) {

            $total = (int) $kegiatanPieRaw
                ->where('dukuh_id', $item->id)
                ->sum('total');


            if ($total > 0) {

                $kegiatanPieLabels[] = $item->nama_dukuh;

                $kegiatanPieData[] = $total;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL KEGIATAN
        |--------------------------------------------------------------------------
        */

        $totalKegiatan = Kegiatan::query()
            ->whereYear('tanggal', $selectedYear)
            ->when(
                $selectedMonth !== 'all',
                fn ($query) =>
                    $query->whereMonth(
                        'tanggal',
                        (int) $selectedMonth
                    )
            )
            ->count();


        return view(
            'admin.index',
            compact(
                'years',
                'selectedYear',
                'selectedMonth',
                'stackedDatasets',
                'pieLabels',
                'pieData',
                'totalAgenda',
                'kegiatanStackedDatasets',
                'kegiatanPieLabels',
                'kegiatanPieData',
                'totalKegiatan'
            )
        );
    }
}