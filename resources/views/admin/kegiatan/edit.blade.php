@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-900">
            Edit Kegiatan
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Perbarui informasi dan dokumentasi kegiatan.
        </p>

    </div>


    <div class="rounded-2xl border border-gray-200
                bg-white p-6 shadow-sm sm:p-8">

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200
                        bg-red-50 p-4 text-sm text-red-700">

                <ul class="list-disc pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('admin.kegiatan.update', $kegiatan->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
            data-unsaved-form
        >

            @csrf
            @method('PUT')


            {{-- FORMULIR --}}

            @include('admin.kegiatan.fields')


            {{-- FOTO YANG SUDAH ADA --}}

           {{-- ========================================== --}}
            {{-- FOTO YANG SUDAH TERSIMPAN --}}
            {{-- ========================================== --}}

            @if ($kegiatan->fotos->isNotEmpty())

                <div class="border-t border-gray-200 pt-6">

                    {{-- HEADER --}}

                    <div class="mb-5">

                        <h3 class="text-lg font-bold text-gray-900">
                            Foto yang Sudah Tersimpan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Foto berikut sudah tersimpan dalam database.
                            Untuk menghapusnya, gunakan halaman Detail Kegiatan.
                        </p>

                    </div>


                    {{-- GALERI FOTO --}}

                    <div class="grid grid-cols-2 gap-4
                                sm:grid-cols-3 lg:grid-cols-4">

                        @foreach ($kegiatan->fotos as $foto)

                            <div class="overflow-hidden rounded-xl
                                        border border-gray-200
                                        bg-white shadow-sm">

                                {{-- FOTO --}}

                                <img
                                    src="{{ asset('storage/' . $foto->foto) }}"
                                    alt="{{ $foto->keterangan ?? 'Foto Kegiatan' }}"
                                    class="h-36 w-full object-cover
                                        sm:h-40"
                                >


                                {{-- INFORMASI --}}

                                <div class="p-3">

                                    <p class="truncate text-xs
                                            font-semibold text-gray-800">

                                        {{ basename($foto->foto) }}

                                    </p>

                                    <span class="mt-2 inline-flex
                                                rounded-full bg-green-100
                                                px-2 py-1 text-xs
                                                font-semibold text-green-700">

                                        <i class="fa-solid fa-circle-check mr-1"></i>

                                        Tersimpan

                                    </span>

                                    @if ($foto->keterangan)

                                        <p class="mt-2 text-xs text-gray-500">
                                            {{ $foto->keterangan }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- LINK DETAIL --}}

                    <a
                        href="{{ route('admin.kegiatan.show', $kegiatan->id) }}"
                        class="mt-5 inline-flex items-center gap-2
                            text-sm font-semibold text-green-700
                            hover:text-green-800"
                    >

                        <i class="fa-solid fa-images"></i>

                        Kelola Dokumentasi Kegiatan

                        <i class="fa-solid fa-arrow-right text-xs"></i>

                    </a>

                </div>

            @endif


            {{-- BUTTON --}}

            <div class="flex flex-wrap gap-3
                        border-t border-gray-100 pt-6">

                <button
                    type="submit"
                    class="rounded-xl bg-green-600
                           px-6 py-3 font-semibold
                           text-white hover:bg-green-700"
                >
                    Simpan Perubahan
                </button>


                <a
                    href="{{ route('admin.kegiatan.show', $kegiatan->id) }}"
                    data-guard-back
                    class="rounded-xl bg-gray-200
                           px-6 py-3 font-semibold
                           text-gray-700 hover:bg-gray-300"
                >
                    Batal
                </a>

            </div>

        </form>
        <x-unsaved-warning />

    </div>

</div>

@endsection