@extends('layouts.pengunjung')

@section('title', $agenda->judul . ' - Kalurahan Pandowoharjo')

@section('content')

{{-- DETAIL AGENDA --}}

<section class="py-10 sm:py-14">

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        {{-- TOMBOL KEMBALI --}}

        <a href="{{ route('agenda.index') }}"
           class="mb-6 inline-flex items-center gap-2
                  text-sm font-semibold text-green-700
                  hover:text-green-900">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Daftar Agenda

        </a>


        {{-- CARD UTAMA --}}

        <article class="overflow-hidden rounded-3xl
                        border border-gray-200 bg-white shadow-sm">


            {{-- FOTO UTAMA --}}

            <div class="relative h-64 bg-green-50 sm:h-80 lg:h-96">

                @if ($agenda->fotos->isNotEmpty())

                    <button
                        type="button"
                        class="block h-full w-full cursor-zoom-in"
                        data-image="{{ asset('storage/' . $agenda->fotos->first()->foto) }}"
                        data-caption="{{ $agenda->fotos->first()->keterangan ?? $agenda->judul }}"
                        onclick="openImageModal(this)"
                    >

                        <img
                            src="{{ asset('storage/' . $agenda->fotos->first()->foto) }}"
                            alt="{{ $agenda->judul }}"
                            class="h-full w-full object-cover"
                        >

                    </button>

                @else

                    <div class="flex h-full flex-col
                                items-center justify-center
                                bg-gradient-to-br
                                from-green-100 to-green-50
                                text-green-600">

                        <i class="fa-solid fa-calendar-days
                                  mb-4 text-6xl"></i>

                        <span class="font-semibold">
                            Agenda Kalurahan
                        </span>

                    </div>

                @endif


                {{-- STATUS --}}

                @php
                    $statusColors = [
                        'direncanakan' => 'bg-blue-100 text-blue-700',
                        'selesai' => 'bg-green-100 text-green-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                    ];
                @endphp

                <div class="absolute right-5 top-5 pointer-events-none">

                    <span class="rounded-full px-4 py-2
                                 text-sm font-semibold shadow
                                 {{ $statusColors[$agenda->status] ?? 'bg-gray-100 text-gray-700' }}">

                        {{ ucfirst($agenda->status) }}

                    </span>

                </div>

            </div>


            {{-- KONTEN --}}

            <div class="p-6 sm:p-8 lg:p-10">


                {{-- IDENTITAS DUKUH --}}

                <div class="mb-3 flex items-center gap-2
                            text-sm font-semibold text-green-700">

                    <i class="fa-solid fa-house"></i>

                    Dukuh {{ $agenda->dukuh->nama_dukuh ?? '-' }}

                </div>


                {{-- JUDUL --}}

                <h2 class="text-2xl font-bold
                           leading-tight text-gray-900
                           sm:text-4xl">

                    {{ $agenda->judul }}

                </h2>


                {{-- INFORMASI UTAMA --}}

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">


                    {{-- TANGGAL --}}

                    <div class="rounded-2xl border border-gray-200
                                bg-gray-50 p-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-green-100
                                        text-green-700">

                                <i class="fa-regular fa-calendar"></i>

                            </div>

                            <div>

                                <p class="text-xs uppercase text-gray-400">
                                    Tanggal
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">

                                    {{ $agenda->tanggal
                                        ->locale('id')
                                        ->translatedFormat('l, d F Y') }}

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- WAKTU --}}

                    <div class="rounded-2xl border border-gray-200
                                bg-gray-50 p-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-blue-100
                                        text-blue-700">

                                <i class="fa-regular fa-clock"></i>

                            </div>

                            <div>

                                <p class="text-xs uppercase text-gray-400">
                                    Waktu
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">

                                    {{ substr($agenda->waktu_mulai, 11, 5) }}

                                    -

                                    {{ substr($agenda->waktu_selesai, 11, 5) }}

                                    WIB

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- LOKASI --}}

                    <div class="rounded-2xl border border-gray-200
                                bg-gray-50 p-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-red-100
                                        text-red-700">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>

                            <div>

                                <p class="text-xs uppercase text-gray-400">
                                    Lokasi
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">

                                    {{ $agenda->lokasi }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- DESKRIPSI --}}

                <div class="mt-10">

                    <h3 class="mb-4 text-xl font-bold text-gray-900">
                        Deskripsi Agenda
                    </h3>

                    <div class="rounded-2xl border border-gray-200
                                bg-gray-50 p-6">

                        <p class="whitespace-pre-line
                                  leading-7 text-gray-600">{{ $agenda->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

                    </div>

                </div>


                {{-- INFORMASI DUKUH --}}

                <div class="mt-10">

                    <h3 class="mb-4 text-xl font-bold text-gray-900">
                        Informasi Dukuh
                    </h3>


                    <div class="rounded-2xl border border-gray-200 p-6">

                        <div class="grid gap-6 md:grid-cols-3">

                            <div>

                                <p class="text-sm text-gray-400">
                                    Nama Dukuh
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">
                                    {{ $agenda->dukuh->nama_dukuh ?? '-' }}
                                </p>

                            </div>


                            <div>

                                <p class="text-sm text-gray-400">
                                    Kepala Dukuh
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">
                                    {{ $agenda->dukuh->nama_kepala_dukuh ?? '-' }}
                                </p>

                            </div>


                            <div>

                                <p class="text-sm text-gray-400">
                                    Alamat
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">
                                    {{ $agenda->dukuh->alamat ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- GALERI FOTO --}}

                <div class="mt-10">

                    <div class="mb-4 flex items-center justify-between">

                        <h3 class="text-xl font-bold text-gray-900">
                            Dokumentasi Agenda
                        </h3>

                        <span class="text-sm text-gray-500">

                            {{ $agenda->fotos->count() }} Foto

                        </span>

                    </div>


                    @if ($agenda->fotos->isNotEmpty())

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                            @foreach ($agenda->fotos as $foto)

                                <div class="overflow-hidden rounded-2xl
                                            border border-gray-200 bg-white">

                                    {{-- FOTO --}}

                                    <button
                                        type="button"
                                        class="block w-full cursor-zoom-in
                                               overflow-hidden"
                                        data-image="{{ asset('storage/' . $foto->foto) }}"
                                        data-caption="{{ $foto->keterangan ?? $agenda->judul }}"
                                        onclick="openImageModal(this)"
                                    >

                                        <img
                                            src="{{ asset('storage/' . $foto->foto) }}"
                                            alt="{{ $foto->keterangan ?? $agenda->judul }}"
                                            class="h-52 w-full object-cover
                                                   transition duration-300
                                                   hover:scale-105"
                                        >

                                    </button>


                                    {{-- KETERANGAN --}}

                                    @if ($foto->keterangan)

                                        <div class="p-4">

                                            <p class="text-sm text-gray-600">
                                                {{ $foto->keterangan }}
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl border border-dashed
                                    border-gray-300 bg-gray-50
                                    px-6 py-10 text-center">

                            <i class="fa-regular fa-images
                                      mb-3 text-4xl text-gray-300"></i>

                            <p class="text-sm text-gray-500">
                                Belum ada dokumentasi foto.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- KEMBALI --}}

                <div class="mt-10 border-t border-gray-100 pt-6">

                    <a href="{{ route('agenda.index') }}"
                       class="inline-flex items-center gap-2
                              rounded-xl bg-green-600 px-5 py-3
                              text-sm font-semibold text-white
                              transition hover:bg-green-700">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali ke Daftar Agenda

                    </a>

                </div>

            </div>

        </article>

    </div>

</section>


{{-- POPUP FOTO --}}

<div
    id="imageModal"
    class="fixed inset-0 z-50 hidden items-center
           justify-center bg-black/90 p-4"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau foto agenda"
    onclick="closeImageModal(event)"
>

    <div class="relative flex max-h-[95vh]
                w-full max-w-6xl flex-col items-center">

        {{-- CLOSE --}}

        <button
            type="button"
            onclick="closeImageModal()"
            class="absolute right-0 top-0 z-10
                   flex h-10 w-10 items-center justify-center
                   rounded-full bg-white text-gray-800
                   shadow-lg transition hover:bg-gray-200"
            aria-label="Tutup foto"
        >

            <i class="fa-solid fa-xmark"></i>

        </button>


        {{-- FOTO PENUH --}}

        <img
            id="modalImage"
            src=""
            alt=""
            class="max-h-[85vh] max-w-full
                   rounded-xl object-contain shadow-2xl"
        >


        {{-- CAPTION --}}

        <p id="modalCaption"
           class="mt-4 text-center text-sm text-white"></p>

    </div>

</div>

@endsection


{{-- JAVASCRIPT POPUP --}}

@push('scripts')

<script>

    let previousFocus = null;

    function openImageModal(button) {

        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        const caption = document.getElementById('modalCaption');

        previousFocus = document.activeElement;

        image.src = button.dataset.image;
        image.alt = button.dataset.caption;

        caption.textContent = button.dataset.caption;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';

        modal.querySelector('button').focus();

    }


    function closeImageModal(event) {

        const modal = document.getElementById('imageModal');

        if (event && event.target !== modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.getElementById('modalImage').src = '';

        document.body.style.overflow = '';

        if (previousFocus) {
            previousFocus.focus();
        }

    }


    document.addEventListener('keydown', function(event) {

        const modal = document.getElementById('imageModal');

        if (modal.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape') {
            closeImageModal();
        }

        if (event.key === 'Tab') {

            event.preventDefault();

            modal.querySelector('button').focus();

        }

    });

</script>

@endpush