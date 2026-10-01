@extends('layouts.admin')


@section('title', 'Tambah Agenda')

@section('content')

<div class="mx-auto max-w-4xl">


    {{-- HEADER --}}

    <div class="mb-6">

        <a
            href="{{ route('admin.agenda') }}"
            class="mb-4 inline-flex items-center gap-2
                   text-sm font-semibold text-green-700
                   hover:text-green-800"
        >
            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Daftar Agenda
        </a>


        <h1 class="text-3xl font-bold text-gray-900">
            Tambah Agenda
        </h1>


        <p class="mt-2 text-sm text-gray-500">
            Tambahkan agenda baru beserta dokumentasi foto
            Kalurahan Pandowoharjo.
        </p>

    </div>


    {{-- CARD FORM --}}

    <div class="rounded-2xl border border-gray-200
                bg-white p-6 shadow-sm sm:p-8">


        {{-- VALIDASI ERROR --}}

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200
                        bg-red-50 p-4 text-sm text-red-700">

                <p class="mb-2 font-semibold">
                    Periksa kembali data berikut:
                </p>

                <ul class="list-disc space-y-1 pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}

        <form
            action="{{ route('admin.agenda.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
            data-unsaved-form
        >

            @csrf


            {{-- KOMPONEN FIELDS --}}

            @include('admin.agenda.fields')


            {{-- BUTTON --}}

            <div class="flex flex-wrap gap-3
                        border-t border-gray-100 pt-6">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-green-600
                           px-6 py-3 font-semibold text-white
                           transition hover:bg-green-700"
                >
                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan Agenda
                </button>


                <a
                    href="{{ route('admin.agenda') }}"
                    data-guard-back
                    class="inline-flex items-center gap-2
                           rounded-xl bg-gray-200
                           px-6 py-3 font-semibold text-gray-700
                           transition hover:bg-gray-300"
                >
                    Batal
                </a>

            </div>

        </form>
        {{-- PERINGATAN DATA BELUM DISIMPAN --}}

        <x-unsaved-warning />

    </div>

</div>

@endsection