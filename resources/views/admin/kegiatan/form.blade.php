@extends('layouts.admin')

@php
    $isRealization = isset($sourceAgenda);
@endphp

@section('title', 'Tambah Kegiatan')

@section('content')

<div class="mx-auto max-w-4xl">

    {{-- HEADER --}}

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-900">

    {{ $isRealization
        ? 'Realisasi Agenda'
        : 'Tambah Kegiatan' }}

        </h1>


        <p class="mt-2 text-sm text-gray-500">

            @if ($isRealization)

                Catat pelaksanaan agenda
                "{{ $sourceAgenda->judul }}"
                sebagai kegiatan.

            @else

                Tambahkan informasi kegiatan dan
                dokumentasi foto.

            @endif

        </p>

        <p class="mt-2 text-sm text-gray-500">
            Tambahkan informasi kegiatan dan dokumentasi foto.
        </p>

    </div>


    {{-- FORM --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-6 shadow-sm sm:p-8">

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200
                        bg-red-50 p-4 text-sm text-red-700">

                <p class="mb-2 font-semibold">
                    Periksa kembali data berikut:
                </p>

                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <form
            action="{{ $isRealization
                ? route('admin.agenda.realisasi.store', $sourceAgenda->id)
                : route('admin.kegiatan.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
            data-unsaved-form
        >

            @csrf

            @include('admin.kegiatan.fields')


            {{-- BUTTON --}}

            <div class="flex flex-wrap gap-3
                        border-t border-gray-100 pt-6">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                        rounded-xl bg-green-600 px-6 py-3
                        font-semibold text-white
                        hover:bg-green-700"
                >

                    <i class="fa-solid fa-floppy-disk"></i>


                    {{ $isRealization
                        ? 'Simpan Realisasi'
                        : 'Simpan Kegiatan' }}

                </button>


                <a
                    href="{{ route('admin.kegiatan') }}"
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