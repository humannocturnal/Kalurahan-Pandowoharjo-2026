@extends('layouts.admin')

@section('title', 'Tambah Dukuh')

@section('content')

<div class="mx-auto max-w-4xl">

    {{-- HEADER --}}
    <div class="mb-6">

        <a
            href="{{ route('admin.dukuh') }}"
            class="mb-4 inline-flex items-center gap-2
                   text-sm font-semibold text-green-700
                   hover:text-green-800"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Dukuh
        </a>

        <h1 class="text-3xl font-bold text-gray-900">
            Tambah Dukuh
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Tambahkan data dukuh Kalurahan Pandowoharjo.
        </p>

    </div>


    {{-- CARD FORM --}}
    <div class="rounded-2xl border border-gray-200
                bg-white p-6 shadow-sm sm:p-8">

        {{-- ERROR --}}
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


        <form
            action="{{ route('admin.dukuh.store') }}"
            method="POST"
            class="space-y-6"
        >

            @csrf


            {{-- NAMA DUKUH --}}
            <div>

                <label
                    for="nama_dukuh"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Nama Dukuh
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="nama_dukuh"
                    id="nama_dukuh"
                    value="{{ old('nama_dukuh') }}"
                    required
                    placeholder="Masukkan nama dukuh"
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 outline-none transition
                           focus:border-green-500
                           focus:ring-2 focus:ring-green-100"
                >

                @error('nama_dukuh')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- NAMA KEPALA DUKUH --}}
            <div>

                <label
                    for="nama_kepala_dukuh"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Nama Kepala Dukuh
                </label>

                <input
                    type="text"
                    name="nama_kepala_dukuh"
                    id="nama_kepala_dukuh"
                    value="{{ old('nama_kepala_dukuh') }}"
                    placeholder="Masukkan nama kepala dukuh"
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 outline-none transition
                           focus:border-green-500
                           focus:ring-2 focus:ring-green-100"
                >

                @error('nama_kepala_dukuh')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ALAMAT --}}
            <div>

                <label
                    for="alamat"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    id="alamat"
                    rows="4"
                    placeholder="Masukkan alamat dukuh"
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 outline-none transition
                           focus:border-green-500
                           focus:ring-2 focus:ring-green-100"
                >{{ old('alamat') }}</textarea>

                @error('alamat')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- BUTTON --}}
            <div class="flex flex-wrap gap-3
                        border-t border-gray-100 pt-6">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-green-600
                           px-6 py-3 font-semibold
                           text-white transition
                           hover:bg-green-700"
                >
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Dukuh
                </button>

                <a
                    href="{{ route('admin.dukuh') }}"
                    class="inline-flex items-center gap-2
                           rounded-xl bg-gray-200
                           px-6 py-3 font-semibold
                           text-gray-700 transition
                           hover:bg-gray-300"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection