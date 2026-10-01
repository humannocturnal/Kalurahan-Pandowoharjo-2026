@extends('layouts.pengunjung')

@section('title', 'Daftar Agenda - Kalurahan Pandowoharjo')

@section('content')

{{-- DAFTAR AGENDA --}}

<section class="py-10 sm:py-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- INFORMASI JUMLAH --}}

        <div class="mb-8 flex flex-col gap-3
                    sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">
                    Daftar Agenda
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Terdapat {{ $agenda->total() }} agenda.
                </p>

            </div>

            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2
                      text-sm font-semibold text-green-700
                      hover:text-green-900">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Home

            </a>

        </div>


        {{-- DATA KOSONG --}}

        @if ($agenda->isEmpty())

            <div class="rounded-2xl border border-dashed
                        border-gray-300 bg-white
                        px-6 py-16 text-center">

                <i class="fa-regular fa-calendar-xmark
                          mb-4 text-5xl text-gray-300"></i>

                <h3 class="text-lg font-semibold text-gray-800">
                    Belum Ada Agenda
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Saat ini belum terdapat agenda yang tersedia.
                </p>

            </div>

        @else

            {{-- CARD AGENDA --}}

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($agenda as $item)

                    <article class="group flex h-full flex-col
                                    overflow-hidden rounded-2xl
                                    border border-gray-200 bg-white
                                    shadow-sm transition duration-300
                                    hover:-translate-y-1 hover:shadow-lg">

                        {{-- FOTO --}}

                        <div class="relative h-52 overflow-hidden bg-green-50">

                            @if ($item->fotos->isNotEmpty())

                                <img
                                    src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                                    alt="{{ $item->judul }}"
                                    class="h-full w-full object-cover
                                           transition duration-500
                                           group-hover:scale-105"
                                >

                            @else

                                <div class="flex h-full flex-col
                                            items-center justify-center
                                            bg-gradient-to-br
                                            from-green-100 to-green-50
                                            text-green-600">

                                    <i class="fa-solid fa-calendar-days
                                              mb-3 text-5xl"></i>

                                    <span class="text-sm font-semibold">
                                        Agenda Kalurahan
                                    </span>

                                </div>

                            @endif


                            {{-- STATUS --}}

                            <div class="absolute right-3 top-3">

                                @php
                                    $statusColors = [
                                        'direncanakan' => 'bg-blue-100 text-blue-700',
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'dibatalkan' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp

                                <span class="rounded-full px-3 py-1
                                             text-xs font-semibold shadow-sm
                                             {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700' }}">

                                    {{ ucfirst($item->status) }}

                                </span>

                            </div>

                        </div>


                        {{-- KONTEN CARD --}}

                        <div class="flex flex-1 flex-col p-5">

                            {{-- TANGGAL --}}

                            <div class="mb-3 flex items-center gap-2
                                        text-sm font-semibold text-green-700">

                                <i class="fa-regular fa-calendar"></i>

                                {{ $item->tanggal
                                    ->locale('id')
                                    ->translatedFormat('l, d F Y') }}

                            </div>


                            {{-- JUDUL --}}

                            <h3 class="mb-3 text-xl font-bold
                                       leading-snug text-gray-900">

                                {{ $item->judul }}

                            </h3>


                            {{-- DUKUH --}}

                            <div class="mb-4 flex items-center gap-2
                                        text-sm text-gray-500">

                                <i class="fa-solid fa-house"></i>

                                Dukuh {{ $item->dukuh->nama_dukuh ?? '-' }}

                            </div>


                            {{-- DESKRIPSI --}}

                            <p class="mb-5 text-sm leading-relaxed
                                      text-gray-600">

                                {{ \Illuminate\Support\Str::limit(
                                    $item->deskripsi,
                                    120
                                ) }}

                            </p>


                            {{-- INFORMASI --}}

                            <div class="mt-auto space-y-3
                                        border-t border-gray-100 pt-4">

                                <div class="flex items-center gap-3
                                            text-sm text-gray-600">

                                    <i class="fa-regular fa-clock
                                              w-4 text-blue-600"></i>

                                    {{ substr($item->waktu_mulai, 11, 5) }}

                                    -

                                    {{ substr($item->waktu_selesai, 11, 5) }}

                                    WIB

                                </div>


                                <div class="flex items-start gap-3
                                            text-sm text-gray-600">

                                    <i class="fa-solid fa-location-dot
                                              mt-1 w-4 text-red-600"></i>

                                    <span>{{ $item->lokasi }}</span>

                                </div>


                                {{-- DETAIL --}}

                                <a href="{{ route('agenda.show', $item->id) }}"
                                   class="mt-4 inline-flex w-full
                                          items-center justify-center gap-2
                                          rounded-xl bg-green-600
                                          px-4 py-3 text-sm font-semibold
                                          text-white transition
                                          hover:bg-green-700">

                                    Lihat Detail

                                    <i class="fa-solid fa-arrow-right"></i>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- PAGINATION --}}

            <div class="mt-10">

                {{ $agenda->links() }}

            </div>

        @endif

    </div>

</section>

@endsection