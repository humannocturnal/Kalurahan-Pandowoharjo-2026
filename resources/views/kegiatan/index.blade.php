@extends('layouts.pengunjung')

@section('title', 'Daftar Kegiatan - Kalurahan Pandowoharjo')

@section('content')

{{-- ============================================ --}}
{{-- DAFTAR KEGIATAN --}}
{{-- ============================================ --}}

<section class="py-10 sm:py-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


        {{-- HEADER DAFTAR --}}

        <div
            class="mb-8 flex flex-col gap-3
                   sm:flex-row sm:items-center
                   sm:justify-between"
        >

            <div>

                <h2 class="text-2xl font-bold text-gray-900">

                    Daftar Kegiatan

                </h2>


                <p class="mt-1 text-sm text-gray-500">

                    Terdapat {{ $kegiatan->total() }} kegiatan.

                </p>

            </div>


            <a
                href="{{ route('home') }}"
                class="inline-flex items-center gap-2
                       text-sm font-semibold text-green-700
                       hover:text-green-900"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Home

            </a>

        </div>


        {{-- ====================================== --}}
        {{-- JIKA DATA KOSONG --}}
        {{-- ====================================== --}}

        @if ($kegiatan->isEmpty())

            <div
                class="rounded-2xl border border-dashed
                       border-gray-300 bg-white
                       px-6 py-16 text-center"
            >

                <i
                    class="fa-solid fa-people-group
                           mb-4 text-5xl text-gray-300"
                ></i>


                <h3 class="text-lg font-semibold text-gray-800">

                    Belum Ada Kegiatan

                </h3>


                <p class="mt-2 text-sm text-gray-500">

                    Saat ini belum terdapat dokumentasi
                    kegiatan yang tersedia.

                </p>

            </div>


        @else


            {{-- ====================================== --}}
            {{-- GRID KEGIATAN --}}
            {{-- ====================================== --}}

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">


                @foreach ($kegiatan as $item)


                    <article
                        class="group flex h-full flex-col
                               overflow-hidden rounded-2xl
                               border border-gray-200
                               bg-white shadow-sm
                               transition duration-300
                               hover:-translate-y-1
                               hover:shadow-lg"
                    >


                        {{-- ========================== --}}
                        {{-- FOTO KEGIATAN --}}
                        {{-- ========================== --}}

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

                            <div class="flex h-full flex-col items-center justify-center
                                        bg-gradient-to-br from-orange-100 to-orange-50
                                        text-orange-600">

                                <i class="fa-solid fa-people-group mb-3 text-5xl"></i>

                                <span class="text-sm font-semibold">
                                    Kegiatan Kalurahan
                                </span>

                            </div>


                            @endif



                            {{-- LABEL TANGGAL --}}

                            <div
                                class="absolute bottom-3 left-3
                                       rounded-xl bg-white
                                       px-4 py-2 shadow-md"
                            >

                                <p class="text-xl font-bold text-green-700">

                                    {{ $item->tanggal->format('d') }}

                                </p>


                                <p
                                    class="text-xs font-semibold
                                           uppercase text-gray-600"
                                >

                                    {{ $item->tanggal
                                        ->locale('id')
                                        ->translatedFormat('M Y') }}

                                </p>

                            </div>


                        </div>



                        {{-- ========================== --}}
                        {{-- INFORMASI KEGIATAN --}}
                        {{-- ========================== --}}

                        <div class="flex flex-1 flex-col p-5">


                            {{-- NAMA DUKUH --}}

                            <div
                                class="mb-3 flex items-center
                                       gap-2 text-sm font-semibold
                                       text-green-700"
                            >


                                <i class="fa-solid fa-house"></i>


                                <span>

                                    Dukuh
                                    {{ $item->dukuh->nama_dukuh ?? '-' }}

                                </span>


                            </div>



                            {{-- JUDUL --}}

                            <h3
                                class="mb-3 text-xl font-bold
                                       leading-snug text-gray-900"
                            >

                                {{ $item->judul }}

                            </h3>



                            {{-- TANGGAL --}}

                            <div
                                class="mb-3 flex items-center
                                       gap-2 text-sm text-gray-500"
                            >

                                <i class="fa-regular fa-calendar"></i>


                                {{ $item->tanggal
                                    ->locale('id')
                                    ->translatedFormat('l, d F Y') }}


                            </div>



                            {{-- DESKRIPSI --}}

                            <p
                                class="mb-5 text-sm leading-relaxed
                                       text-gray-600"
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    $item->deskripsi,
                                    120
                                ) }}

                            </p>



                            {{-- INFORMASI TAMBAHAN --}}

                            <div
                                class="mt-auto space-y-3
                                       border-t border-gray-100
                                       pt-4"
                            >


                                {{-- LOKASI --}}

                                <div
                                    class="flex items-start gap-3
                                           text-sm text-gray-600"
                                >


                                    <i
                                        class="fa-solid fa-location-dot
                                               mt-1 w-4 text-red-600"
                                    ></i>


                                    <span>

                                        {{ $item->lokasi ?: '-' }}

                                    </span>


                                </div>



                                {{-- DETAIL --}}

                                <a
                                    href="{{ route('kegiatan.show', $item->id) }}"
                                    class="mt-4 inline-flex w-full
                                           items-center justify-center
                                           gap-2 rounded-xl
                                           bg-green-600 px-4 py-3
                                           text-sm font-semibold
                                           text-white transition
                                           hover:bg-green-700"
                                >


                                    Lihat Detail


                                    <i
                                        class="fa-solid fa-arrow-right"
                                    ></i>


                                </a>


                            </div>


                        </div>


                    </article>


                @endforeach


            </div>



            {{-- ====================================== --}}
            {{-- PAGINATION --}}
            {{-- ====================================== --}}

            <div class="mt-10">

                {{ $kegiatan->links() }}

            </div>


        @endif


    </div>

</section>

@endsection