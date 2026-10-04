@extends('layouts.admin')

@section('title', 'Detail Kegiatan')

@section('content')

{{-- HEADER --}}

<div class="mb-6 flex flex-col gap-4
            sm:flex-row sm:items-center sm:justify-between">

    <div>

        <a
            href="{{ route('admin.kegiatan') }}"
            class="mb-3 inline-flex items-center gap-2
                   text-sm font-semibold text-green-700"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Kegiatan
        </a>

        <h1 class="text-3xl font-bold text-gray-900">
            Detail Kegiatan
        </h1>

    </div>


    <a
        href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}"
        class="inline-flex items-center justify-center gap-2
               rounded-xl bg-blue-600 px-5 py-3
               text-sm font-semibold text-white
               hover:bg-blue-700"
    >
        <i class="fa-solid fa-pen"></i>
        Edit Kegiatan
    </a>

</div>


{{-- INFORMASI --}}

<div class="overflow-hidden rounded-2xl
            border border-gray-200 bg-white shadow-sm">

    <div class="p-6 sm:p-8">

        {{-- JUDUL --}}

        <div class="mb-8">

            <span class="inline-flex rounded-full
                         {{ $kegiatan->agenda
                            ? 'bg-green-100 text-green-700'
                            : 'bg-orange-100 text-orange-700' }}
                         px-3 py-1 text-xs font-semibold">

                {{ $kegiatan->agenda
                    ? 'Realisasi Agenda'
                    : 'Kegiatan Insidental' }}

            </span>

            <h2 class="mt-4 text-2xl font-bold text-gray-900">

                {{ $kegiatan->judul }}

            </h2>

        </div>


        {{-- GRID INFORMASI --}}

        <div class="grid gap-5 sm:grid-cols-2">

            <div class="rounded-xl bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Dukuh
                </p>

                <p class="mt-2 font-semibold text-gray-800">
                    {{ $kegiatan->dukuh->nama_dukuh ?? '-' }}
                </p>

            </div>


            <div class="rounded-xl bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Tanggal Pelaksanaan
                </p>

                <p class="mt-2 font-semibold text-gray-800">

                    {{ $kegiatan->tanggal
                        ->locale('id')
                        ->translatedFormat('l, d F Y') }}

                </p>

            </div>


            <div class="rounded-xl bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Waktu
                </p>

                <p class="mt-2 font-semibold text-gray-800">

                  

                    @if ($kegiatan->waktu_mulai)

                        {{ substr($kegiatan->waktu_mulai, 0, 5) }}

                        @if ($kegiatan->waktu_selesai)

                            -
                            {{ substr($kegiatan->waktu_selesai, 0, 5) }}

                        @endif

                        WIB

                    @else

                        -

                    @endif

                </p>

            </div>


            <div class="rounded-xl bg-gray-50 p-5">

                <p class="text-sm text-gray-500">
                    Lokasi
                </p>

                <p class="mt-2 font-semibold text-gray-800">
                    {{ $kegiatan->lokasi ?: '-' }}
                </p>

            </div>

        </div>

        {{-- ========================================== --}}
        {{-- LOKASI KEGIATAN --}}
        {{-- ========================================== --}}

        <div class="mt-8">

            <h3 class="mb-4 text-xl font-bold text-gray-900">
                Lokasi Kegiatan
            </h3>

            <x-location-map
                :latitude="$kegiatan->latitude"
                :longitude="$kegiatan->longitude"
            />

        </div>


        {{-- AGENDA ASAL --}}

        <div class="mt-8">

            <h3 class="mb-3 text-lg font-bold text-gray-900">
                Agenda Asal
            </h3>

            <div class="rounded-xl bg-gray-50 p-5">

                @if ($kegiatan->agenda)

                    <a
                        href="{{ route('admin.agenda.show', $kegiatan->agenda->id) }}"
                        class="font-semibold text-green-700
                               hover:underline"
                    >

                        {{ $kegiatan->agenda->judul }}

                        <i class="fa-solid fa-arrow-up-right-from-square
                                  ml-1 text-xs"></i>

                    </a>

                @else

                    <p class="text-gray-600">
                        Kegiatan ini tidak berasal dari agenda.
                    </p>

                @endif

            </div>

        </div>


        {{-- DESKRIPSI --}}

        <div class="mt-8">

            <h3 class="mb-3 text-lg font-bold text-gray-900">
                Deskripsi Kegiatan
            </h3>

            <div class="rounded-xl bg-gray-50 p-5">

                <p class="whitespace-pre-line leading-7 text-gray-600">{{ $kegiatan->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

            </div>

        </div>


        {{-- GALERI FOTO --}}

        <div class="mt-10">

            <div class="mb-5 flex items-center justify-between">

                <h3 class="text-xl font-bold text-gray-900">
                    Dokumentasi Kegiatan
                </h3>

                <span class="text-sm text-gray-500">

                    {{ $kegiatan->fotos->count() }} Foto

                </span>

            </div>


            @if ($kegiatan->fotos->isNotEmpty())

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($kegiatan->fotos as $foto)

                        <div class="overflow-hidden rounded-xl
                                    border border-gray-200 bg-white">

                            <div class="relative">

                                {{-- FOTO --}}

                                <button
                                    type="button"
                                    data-image="{{ asset('storage/' . $foto->foto) }}"
                                    data-caption="{{ $foto->keterangan ?? $kegiatan->judul }}"
                                    onclick="openImageModal(this)"
                                    class="block w-full cursor-zoom-in"
                                >

                                    <img
                                        src="{{ asset('storage/' . $foto->foto) }}"
                                        alt="Dokumentasi Kegiatan"
                                        class="h-52 w-full object-cover"
                                    >

                                </button>


                                {{-- HAPUS FOTO --}}

                                <form
                                    action="{{ route(
                                        'admin.kegiatan.foto.destroy',
                                        [$kegiatan->id, $foto->id]
                                    ) }}"
                                    method="POST"
                                    class="absolute right-3 top-3"
                                    onsubmit="return confirm('Yakin ingin menghapus foto ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="flex h-10 w-10
                                               items-center justify-center
                                               rounded-full bg-red-600
                                               text-white shadow-lg
                                               hover:bg-red-700"
                                        title="Hapus Foto"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </div>


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


        {{-- DELETE KEGIATAN --}}

        <div class="mt-10 border-t border-gray-100 pt-6">

            <form
                action="{{ route('admin.kegiatan.destroy', $kegiatan->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus kegiatan beserta seluruh fotonya?')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="rounded-xl bg-red-600 px-5 py-3
                           font-semibold text-white
                           hover:bg-red-700"
                >

                    <i class="fa-solid fa-trash mr-2"></i>

                    Hapus Kegiatan

                </button>

            </form>

        </div>

    </div>

</div>


{{-- MODAL FOTO --}}

<div
    id="imageModal"
    class="fixed inset-0 z-50 hidden
           items-center justify-center bg-black/90 p-4"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau foto kegiatan"
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