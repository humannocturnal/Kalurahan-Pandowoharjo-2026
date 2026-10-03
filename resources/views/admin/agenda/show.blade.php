@extends('layouts.admin')

@section('title', 'Detail Agenda')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>

        <a
            href="{{ route('admin.agenda') }}"
            class="mb-3 inline-flex items-center gap-2
                   text-sm font-semibold text-green-700
                   hover:text-green-800"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Agenda
        </a>

        <h1 class="text-3xl font-bold text-gray-900">
            Detail Agenda
        </h1>

    </div>

   

    {{-- TOMBOL AKSI --}}

<div class="flex flex-wrap items-center gap-3">

    {{-- REALISASIKAN AGENDA --}}

    @if ($agenda->status === 'direncanakan')

        <a
            href="{{ route('admin.agenda.realisasi', $agenda->id) }}"
            class="inline-flex items-center justify-center gap-2
                   rounded-xl bg-green-600 px-5 py-3
                   text-sm font-semibold text-white
                   transition hover:bg-green-700"
        >

            <i class="fa-solid fa-calendar-check"></i>

            Realisasikan Agenda

        </a>

    @endif


    {{-- EDIT AGENDA --}}

    <a
        href="{{ route('admin.agenda.edit', $agenda->id) }}"
        class="inline-flex items-center justify-center gap-2
               rounded-xl bg-blue-600 px-5 py-3
               text-sm font-semibold text-white
               transition hover:bg-blue-700"
    >

        <i class="fa-solid fa-pen"></i>

        Edit Agenda

    </a>

</div>

</div>


{{-- CARD UTAMA --}}
<div class="overflow-hidden rounded-2xl
            border border-gray-200 bg-white shadow-sm">

    <div class="p-6 sm:p-8">

        {{-- JUDUL DAN STATUS --}}
        <div class="mb-8 flex flex-col gap-4
                    sm:flex-row sm:items-start sm:justify-between">

            <div>

                <p class="mb-2 text-sm font-semibold text-green-600">
                    Agenda Kalurahan
                </p>

                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                    {{ $agenda->judul }}
                </h2>

            </div>


            {{-- STATUS --}}
            @php
                $statusColors = [
                    'direncanakan' => 'bg-blue-100 text-blue-700',
                    'selesai' => 'bg-green-100 text-green-700',
                    'dibatalkan' => 'bg-red-100 text-red-700',
                ];
            @endphp

            <span
                class="inline-flex w-fit items-center
                       rounded-full px-4 py-2
                       text-sm font-semibold
                       {{ $statusColors[$agenda->status] ?? 'bg-gray-100 text-gray-700' }}"
            >
                {{ ucfirst($agenda->status) }}
            </span>

        </div>


        {{-- INFORMASI UTAMA --}}
        <div class="grid gap-5 sm:grid-cols-2">

            {{-- DUKUH --}}
            <div class="rounded-xl bg-gray-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0
                                items-center justify-center
                                rounded-xl bg-green-100 text-green-700">

                        <i class="fa-solid fa-house"></i>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
                            Dukuh
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $agenda->dukuh->nama_dukuh ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- TANGGAL --}}
            <div class="rounded-xl bg-gray-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0
                                items-center justify-center
                                rounded-xl bg-blue-100 text-blue-700">

                        <i class="fa-regular fa-calendar"></i>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
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
            <div class="rounded-xl bg-gray-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0
                                items-center justify-center
                                rounded-xl bg-yellow-100 text-yellow-700">

                        <i class="fa-regular fa-clock"></i>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
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
            <div class="rounded-xl bg-gray-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0
                                items-center justify-center
                                rounded-xl bg-red-100 text-red-700">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>

                    <div>

                        <p class="text-sm text-gray-500">
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
        <div class="mt-8">

            <h3 class="mb-3 text-xl font-bold text-gray-900">
                Deskripsi Agenda
            </h3>

            <div class="rounded-xl bg-gray-50 p-5">

                <p class="whitespace-pre-line leading-7 text-gray-600">{{ $agenda->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

            </div>

        </div>


        {{-- INFORMASI DUKUH --}}
        <div class="mt-8">

            <h3 class="mb-3 text-xl font-bold text-gray-900">
                Informasi Dukuh
            </h3>

            <div class="grid gap-5 rounded-xl border
                        border-gray-200 p-5 sm:grid-cols-3">

                <div>

                    <p class="text-sm text-gray-500">
                        Nama Dukuh
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $agenda->dukuh->nama_dukuh ?? '-' }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">
                        Kepala Dukuh
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $agenda->dukuh->nama_kepala_dukuh ?? '-' }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">
                        Alamat
                    </p>

                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $agenda->dukuh->alamat ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- ========================================== --}}
        {{-- PETA LOKASI AGENDA --}}
        {{-- ========================================== --}}

        <div class="mt-8">

            <h3 class="mb-4 text-xl font-bold text-gray-900">
                Lokasi Agenda
            </h3>

            <x-location-map
                :latitude="$agenda->latitude"
                :longitude="$agenda->longitude"
            />

        </div>


        {{-- GALERI FOTO --}}
        <div class="mt-10">

            <div class="mb-5 flex items-center justify-between">

                <h3 class="text-xl font-bold text-gray-900">
                    Dokumentasi Agenda
                </h3>

                <span class="text-sm text-gray-500">
                    {{ $agenda->fotos->count() }} Foto
                </span>

            </div>


            @if ($agenda->fotos->isNotEmpty())

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($agenda->fotos as $foto)

                        <div class="overflow-hidden rounded-xl
                                    border border-gray-200 bg-white">

                            <div class="relative">

                                {{-- FOTO DAPAT DIKLIK --}}
                                <button
                                    type="button"
                                    data-image="{{ asset('storage/' . $foto->foto) }}"
                                    data-caption="{{ $foto->keterangan ?? $agenda->judul }}"
                                    onclick="openImageModal(this)"
                                    class="block w-full cursor-zoom-in"
                                    aria-label="Perbesar foto agenda"
                                >

                                    <img
                                        src="{{ asset('storage/' . $foto->foto) }}"
                                        alt="{{ $foto->keterangan ?? $agenda->judul }}"
                                        class="h-52 w-full object-cover
                                               transition hover:opacity-90"
                                    >

                                </button>


                                {{-- TOMBOL HAPUS FOTO --}}
                                <form
                                    action="{{ route(
                                        'admin.agenda.foto.destroy',
                                        [$agenda->id, $foto->id]
                                    ) }}"
                                    method="POST"
                                    class="absolute right-3 top-3"
                                    onsubmit="return confirm('Yakin ingin menghapus foto ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Hapus Foto"
                                        class="flex h-10 w-10
                                               items-center justify-center
                                               rounded-full bg-red-600
                                               text-white shadow-lg
                                               transition hover:bg-red-700"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            </div>


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

                <div class="rounded-xl border border-dashed
                            border-gray-300 bg-gray-50
                            px-6 py-12 text-center">

                    <i class="fa-regular fa-images
                              mb-3 text-4xl text-gray-300"></i>

                    <p class="text-gray-500">
                        Belum ada dokumentasi foto.
                    </p>

                </div>

            @endif

        </div>


        {{-- DELETE AGENDA --}}
        <div class="mt-10 border-t border-gray-100 pt-6">

            <form
                action="{{ route('admin.agenda.destroy', $agenda->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus agenda ini?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-red-600 px-5 py-3
                           font-semibold text-white
                           transition hover:bg-red-700"
                >
                    <i class="fa-solid fa-trash"></i>
                    Hapus Agenda
                </button>

            </form>

        </div>

    </div>

</div>


{{-- MODAL POPUP FOTO --}}
<div
    id="imageModal"
    class="fixed inset-0 z-50 hidden items-center
           justify-center bg-black/90 p-4"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau foto agenda"
    onclick="closeImageModal(event)"
>

    <div class="relative flex w-full max-w-6xl
                flex-col items-center">

        <button
            type="button"
            onclick="closeImageModal()"
            class="absolute right-0 top-0 z-10
                   flex h-10 w-10 items-center
                   justify-center rounded-full
                   bg-white text-gray-800"
            aria-label="Tutup foto"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img
            id="modalImage"
            src=""
            alt=""
            class="max-h-[85vh] max-w-full
                   rounded-xl object-contain"
        >

        <p
            id="modalCaption"
            class="mt-4 text-center text-sm text-white"
        ></p>

    </div>

</div>

@endsection


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

    document.addEventListener('keydown', function (event) {
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