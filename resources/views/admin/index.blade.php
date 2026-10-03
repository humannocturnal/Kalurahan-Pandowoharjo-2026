@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

@php

    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $selectedMonthName =
        $selectedMonth === 'all'
            ? 'Semua Bulan'
            : $months[(int) $selectedMonth];

@endphp


{{-- ========================================== --}}
{{-- HEADER --}}
{{-- ========================================== --}}

<div class="mb-7">

    <h1 class="text-3xl font-bold text-gray-900">
        Dashboard Admin
    </h1>

    <p class="mt-2 text-sm text-gray-500">
        Statistik agenda Kalurahan Pandowoharjo.
    </p>

</div>


{{-- ========================================== --}}
{{-- FILTER --}}
{{-- ========================================== --}}

<div class="mb-7 rounded-2xl border border-gray-200
            bg-white p-5 shadow-sm">

    <form
        action="{{ route('admin.dashboard') }}"
        method="GET"
        class="grid gap-4 md:grid-cols-3"
    >


        {{-- TAHUN --}}

        <div>

            <label
                for="year"
                class="mb-2 block text-sm
                       font-semibold text-gray-700"
            >
                Tahun
            </label>

            <select
                name="year"
                id="year"
                class="w-full rounded-xl border
                       border-gray-300 bg-white
                       px-4 py-3 outline-none
                       focus:border-green-500
                       focus:ring-2
                       focus:ring-green-100"
            >

                @foreach ($years as $year)

                    <option
                        value="{{ $year }}"
                        @selected($selectedYear == $year)
                    >
                        {{ $year }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- BULAN --}}

        <div>

            <label
                for="month"
                class="mb-2 block text-sm
                       font-semibold text-gray-700"
            >
                Bulan
            </label>

            <select
                name="month"
                id="month"
                class="w-full rounded-xl border
                       border-gray-300 bg-white
                       px-4 py-3 outline-none
                       focus:border-green-500
                       focus:ring-2
                       focus:ring-green-100"
            >

                <option
                    value="all"
                    @selected($selectedMonth === 'all')
                >
                    Semua Bulan
                </option>

                @foreach ($months as $number => $name)

                    <option
                        value="{{ $number }}"
                        @selected(
                            (string) $selectedMonth === (string) $number
                        )
                    >
                        {{ $name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- BUTTON --}}

        <div class="flex items-end gap-3">

            <button
                type="submit"
                class="inline-flex flex-1
                       items-center justify-center
                       gap-2 rounded-xl bg-green-600
                       px-5 py-3 font-semibold
                       text-white transition
                       hover:bg-green-700"
            >
                <i class="fa-solid fa-filter"></i>

                Terapkan Filter
            </button>


            <a
                href="{{ route('admin.dashboard') }}"
                title="Reset Filter"
                class="inline-flex h-[50px] w-[50px]
                       shrink-0 items-center justify-center
                       rounded-xl bg-gray-200
                       text-gray-700 transition
                       hover:bg-gray-300"
            >
                <i class="fa-solid fa-rotate-left"></i>
            </a>

        </div>

    </form>

</div>


{{-- ========================================== --}}
{{-- RINGKASAN FILTER --}}
{{-- ========================================== --}}

<div class="mb-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


    {{-- TOTAL AGENDA --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-5 shadow-sm">

        <div class="flex items-center gap-4">

            <div
                class="flex h-12 w-12 shrink-0
                       items-center justify-center
                       rounded-xl bg-green-100
                       text-xl text-green-600"
            >
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Total Agenda
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $totalAgenda }}
                </p>

            </div>

        </div>

    </div>

    {{-- TOTAL KEGIATAN --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-5 shadow-sm">

        <div class="flex items-center gap-4">

            <div
                class="flex h-12 w-12 shrink-0
                    items-center justify-center
                    rounded-xl bg-orange-100
                    text-xl text-orange-600"
            >
                <i class="fa-solid fa-people-group"></i>
            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Total Kegiatan
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $totalKegiatan }}
                </p>

            </div>

        </div>

    </div>


    {{-- TAHUN --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-5 shadow-sm">

        <div class="flex items-center gap-4">

            <div
                class="flex h-12 w-12 shrink-0
                       items-center justify-center
                       rounded-xl bg-blue-100
                       text-xl text-blue-600"
            >
                <i class="fa-solid fa-calendar"></i>
            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Tahun
                </p>

                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $selectedYear }}
                </p>

            </div>

        </div>

    </div>


    {{-- BULAN --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-5 shadow-sm">

        <div class="flex items-center gap-4">

            <div
                class="flex h-12 w-12 shrink-0
                       items-center justify-center
                       rounded-xl bg-orange-100
                       text-xl text-orange-600"
            >
                <i class="fa-solid fa-filter"></i>
            </div>

            <div>

                <p class="text-sm text-gray-500">
                    Periode
                </p>

                <p class="mt-1 font-bold text-gray-900">
                    {{ $selectedMonthName }}
                </p>

            </div>

        </div>

    </div>

</div>


{{-- ========================================== --}}
{{-- AREA GRAFIK --}}
{{-- ========================================== --}}

    {{-- ========================================== --}}
    {{-- STATISTIK AGENDA --}}
    {{-- ========================================== --}}

    <div class="mb-4 mt-2">

        <h2 class="text-2xl font-bold text-gray-900">
            Statistik Agenda
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Statistik agenda berdasarkan dukuh dan periode.
        </p>

    </div>

   
<div class="grid gap-7 xl:grid-cols-3">


    {{-- ====================================== --}}
    {{-- STACKED BAR - 2/3 --}}
    {{-- ====================================== --}}

    <div
        class="rounded-2xl border border-gray-200
               bg-white p-5 shadow-sm sm:p-6
               xl:col-span-2"
    >

        <div class="mb-6">

            <h2 class="text-xl font-bold text-gray-900">
                Agenda per Dukuh
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Jumlah agenda setiap dukuh per bulan
                selama tahun {{ $selectedYear }}.
            </p>

        </div>


        <div class="relative h-[420px] w-full">

            <canvas id="agendaStackedChart"></canvas>

        </div>

    </div>


    {{-- ====================================== --}}
    {{-- PIE CHART - 1/3 --}}
    {{-- ====================================== --}}

    <div
        class="rounded-2xl border border-gray-200
               bg-white p-5 shadow-sm sm:p-6"
    >

        <div class="mb-6">

            <h2 class="text-xl font-bold text-gray-900">
                Perbandingan Agenda
            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Distribusi agenda per dukuh

                @if ($selectedMonth === 'all')

                    selama tahun {{ $selectedYear }}.

                @else

                    pada bulan
                    {{ $selectedMonthName }}
                    {{ $selectedYear }}.

                @endif

            </p>

        </div>


        @if (count($pieData) > 0)

            <div class="relative h-[420px] w-full">

                <canvas id="agendaPieChart"></canvas>

            </div>

        @else

            <div
                class="flex h-[420px] flex-col
                       items-center justify-center
                       rounded-xl border border-dashed
                       border-gray-300 bg-gray-50
                       px-6 text-center"
            >

                <i
                    class="fa-solid fa-chart-pie
                           mb-4 text-5xl text-gray-300"
                ></i>

                <h3 class="font-semibold text-gray-800">
                    Belum Ada Data
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Tidak terdapat agenda pada periode
                    yang dipilih.
                </p>

            </div>

        @endif

    </div>







</div>
 {{-- ========================================== --}}
    {{-- STATISTIK KEGIATAN --}}
    {{-- ========================================== --}}

    <div class="mb-4 mt-10">

        <h2 class="text-2xl font-bold text-gray-900">
            Statistik Kegiatan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Statistik kegiatan berdasarkan dukuh dan periode.
        </p>

    </div>
<div class="grid gap-7 xl:grid-cols-3">


    {{-- ====================================== --}}
    {{-- STACKED BAR KEGIATAN - 2/3 --}}
    {{-- ====================================== --}}

    <div
        class="rounded-2xl border border-gray-200
               bg-white p-5 shadow-sm sm:p-6
               xl:col-span-2"
    >

        <div class="mb-6">

            <h2 class="text-xl font-bold text-gray-900">
                Kegiatan per Dukuh
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Jumlah kegiatan setiap dukuh per bulan
                selama tahun {{ $selectedYear }}.
            </p>

        </div>


        <div class="relative h-[420px] w-full">

            <canvas id="kegiatanStackedChart"></canvas>

        </div>

    </div>


    {{-- ====================================== --}}
    {{-- PIE CHART KEGIATAN - 1/3 --}}
    {{-- ====================================== --}}

    <div
        class="rounded-2xl border border-gray-200
               bg-white p-5 shadow-sm sm:p-6"
    >

        <div class="mb-6">

            <h2 class="text-xl font-bold text-gray-900">
                Perbandingan Kegiatan
            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Distribusi kegiatan per dukuh

                @if ($selectedMonth === 'all')

                    selama tahun {{ $selectedYear }}.

                @else

                    pada bulan
                    {{ $selectedMonthName }}
                    {{ $selectedYear }}.

                @endif

            </p>

        </div>


        @if (count($kegiatanPieData) > 0)

            <div class="relative h-[420px] w-full">

                <canvas id="kegiatanPieChart"></canvas>

            </div>

        @else

            <div
                class="flex h-[420px] flex-col
                       items-center justify-center
                       rounded-xl border border-dashed
                       border-gray-300 bg-gray-50
                       px-6 text-center"
            >

                <i
                    class="fa-solid fa-chart-pie
                           mb-4 text-5xl text-gray-300"
                ></i>

                <h3 class="font-semibold text-gray-800">
                    Belum Ada Data
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Tidak terdapat kegiatan pada periode
                    yang dipilih.
                </p>

            </div>

        @endif

    </div>

</div> 


@endsection


{{-- ========================================== --}}
{{-- CHART.JS --}}
{{-- ========================================== --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA DARI LARAVEL
    |--------------------------------------------------------------------------
    */

    const stackedDatasets = @json($stackedDatasets);

    const pieLabels = @json($pieLabels);

    const pieData = @json($pieData);

    const kegiatanStackedDatasets =
    @json($kegiatanStackedDatasets);

    const kegiatanPieLabels =
        @json($kegiatanPieLabels);

    const kegiatanPieData =
        @json($kegiatanPieData);


    /*
    |--------------------------------------------------------------------------
    | WARNA
    |--------------------------------------------------------------------------
    |
    | Satu dukuh mendapat satu warna.
    |
    */

    const chartColors = [

        '#16a34a',
        '#2563eb',
        '#ea580c',
        '#9333ea',
        '#dc2626',

        '#0891b2',
        '#ca8a04',
        '#4f46e5',
        '#db2777',
        '#65a30d',

        '#0d9488',
        '#7c3aed',
        '#c2410c',
        '#0284c7',
        '#be123c',

        '#15803d',
        '#1d4ed8',
        '#a16207',
        '#6d28d9',
        '#b91c1c'

    ];


    /*
    |--------------------------------------------------------------------------
    | STACKED BAR
    |--------------------------------------------------------------------------
    */

    const stackedCanvas =
        document.getElementById('agendaStackedChart');


    if (stackedCanvas) {

        const formattedDatasets =
            stackedDatasets.map(function (dataset, index) {

                return {

                    label: dataset.label,

                    data: dataset.data,

                    backgroundColor:
                        chartColors[index % chartColors.length],

                    borderColor:
                        chartColors[index % chartColors.length],

                    borderWidth: 1,

                    borderRadius: 4,

                    borderSkipped: false

                };

            });


        new Chart(stackedCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],

                datasets: formattedDatasets

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                interaction: {

                    mode: 'index',

                    intersect: false

                },


                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            padding: 18

                        }

                    },


                    tooltip: {

                        callbacks: {

                            footer: function (items) {

                                const total =
                                    items.reduce(
                                        (sum, item) =>
                                            sum + item.raw,
                                        0
                                    );

                                return 'Total Agenda: ' + total;

                            }

                        }

                    }

                },


                scales: {

                    x: {

                        stacked: true,

                        grid: {

                            display: false

                        }

                    },


                    y: {

                        stacked: true,

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            stepSize: 1

                        },

                        title: {

                            display: true,

                            text: 'Jumlah Agenda'

                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PIE CHART
    |--------------------------------------------------------------------------
    */

    const pieCanvas =
        document.getElementById('agendaPieChart');


    if (pieCanvas && pieData.length > 0) {

        new Chart(pieCanvas, {

            type: 'pie',

            data: {

                labels: pieLabels,

                datasets: [{

                    label: 'Agenda',

                    data: pieData,

                    backgroundColor:
                        pieData.map(
                            (_, index) =>
                                chartColors[index % chartColors.length]
                        ),

                    borderWidth: 2,

                    borderColor: '#ffffff'

                }]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            padding: 18

                        }

                    },


                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                const values =
                                    context.dataset.data;


                                const total =
                                    values.reduce(
                                        (sum, value) =>
                                            sum + value,
                                        0
                                    );


                                const value =
                                    context.raw;


                                const percentage =
                                    total > 0
                                        ? (
                                            (value / total) * 100
                                        ).toFixed(1)
                                        : 0;


                                return (
                                    context.label +
                                    ': ' +
                                    value +
                                    ' agenda (' +
                                    percentage +
                                    '%)'
                                );

                            }

                        }

                    }

                }

            }

        });

    }

    /*
    |--------------------------------------------------------------------------
    | STACKED BAR KEGIATAN
    |--------------------------------------------------------------------------
    */

    const kegiatanStackedCanvas =
        document.getElementById('kegiatanStackedChart');


    if (kegiatanStackedCanvas) {

        const kegiatanFormattedDatasets =
            kegiatanStackedDatasets.map(
                function (dataset, index) {

                    return {

                        label: dataset.label,

                        data: dataset.data,

                        backgroundColor:
                            chartColors[index % chartColors.length],

                        borderColor:
                            chartColors[index % chartColors.length],

                        borderWidth: 1,

                        borderRadius: 4,

                        borderSkipped: false

                    };

                }
            );


        new Chart(kegiatanStackedCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],

                datasets: kegiatanFormattedDatasets

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                interaction: {

                    mode: 'index',

                    intersect: false

                },


                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            padding: 18

                        }

                    },


                    tooltip: {

                        callbacks: {

                            footer: function (items) {

                                const total =
                                    items.reduce(
                                        (sum, item) =>
                                            sum + item.raw,
                                        0
                                    );

                                return 'Total Kegiatan: ' + total;

                            }

                        }

                    }

                },


                scales: {

                    x: {

                        stacked: true,

                        grid: {

                            display: false

                        }

                    },


                    y: {

                        stacked: true,

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            stepSize: 1

                        },

                        title: {

                            display: true,

                            text: 'Jumlah Kegiatan'

                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PIE CHART KEGIATAN
    |--------------------------------------------------------------------------
    */

    const kegiatanPieCanvas =
        document.getElementById('kegiatanPieChart');


    if (
        kegiatanPieCanvas &&
        kegiatanPieData.length > 0
    ) {

        new Chart(kegiatanPieCanvas, {

            type: 'pie',

            data: {

                labels: kegiatanPieLabels,

                datasets: [{

                    label: 'Kegiatan',

                    data: kegiatanPieData,

                    backgroundColor:
                        kegiatanPieData.map(
                            (_, index) =>
                                chartColors[index % chartColors.length]
                        ),

                    borderWidth: 2,

                    borderColor: '#ffffff'

                }]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            padding: 18

                        }

                    },


                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                const values =
                                    context.dataset.data;


                                const total =
                                    values.reduce(
                                        (sum, value) =>
                                            sum + value,
                                        0
                                    );


                                const value = context.raw;


                                const percentage =
                                    total > 0
                                        ? (
                                            (value / total) * 100
                                        ).toFixed(1)
                                        : 0;


                                return (
                                    context.label +
                                    ': ' +
                                    value +
                                    ' kegiatan (' +
                                    percentage +
                                    '%)'
                                );

                            }

                        }

                    }

                }

            }

        });

    }

});

</script>

@endpush