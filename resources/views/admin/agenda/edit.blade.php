@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')

<div class="mx-auto max-w-4xl">


    {{-- HEADER --}}

    <div class="mb-6">

        <a
            href="{{ route('admin.agenda.show', $agenda->id) }}"
            class="mb-4 inline-flex items-center gap-2
                   text-sm font-semibold text-green-700
                   hover:text-green-800"
        >
            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Detail Agenda
        </a>


        <h1 class="text-3xl font-bold text-gray-900">
            Edit Agenda
        </h1>


        <p class="mt-2 text-sm text-gray-500">
            Perbarui informasi agenda dan tambahkan
            dokumentasi foto apabila diperlukan.
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


        {{-- FORM EDIT --}}

        <form
            action="{{ route('admin.agenda.update', $agenda->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
            data-unsaved-form
        >

            @csrf

            @method('PUT')


            {{-- KOMPONEN FIELDS --}}

            @include('admin.agenda.fields')


            {{-- FOTO YANG SUDAH TERSIMPAN --}}

            @if ($agenda->fotos->isNotEmpty())

                <div class="border-t border-gray-200 pt-6">

                    <div class="mb-4">

                        <h3 class="text-lg font-bold text-gray-900">
                            Foto yang Sudah Tersimpan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Foto berikut merupakan dokumentasi
                            yang sudah tersimpan sebelumnya.
                        </p>

                    </div>


                    <div class="grid grid-cols-2 gap-4
                                sm:grid-cols-3 lg:grid-cols-4">

                        @foreach ($agenda->fotos as $foto)

                            <div class="overflow-hidden
                                        rounded-xl border
                                        border-gray-200 bg-white">

                                <img
                                    src="{{ asset('storage/' . $foto->foto) }}"
                                    alt="{{ $foto->keterangan ?? 'Foto Agenda' }}"
                                    class="h-36 w-full object-cover"
                                >

                                @if ($foto->keterangan)

                                    <p class="p-3 text-xs text-gray-600">
                                        {{ $foto->keterangan }}
                                    </p>

                                @endif

                            </div>

                        @endforeach

                    </div>


                    <p class="mt-4 text-sm text-gray-500">

                        Untuk menghapus foto yang sudah tersimpan,
                        gunakan halaman Detail Agenda.

                    </p>

                </div>

            @endif


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

                    Simpan Perubahan
                </button>


                <a
                    href="{{ route('admin.agenda.show', $agenda->id) }}"
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
        <x-unsaved-warning />

    </div>

</div>

@endsection