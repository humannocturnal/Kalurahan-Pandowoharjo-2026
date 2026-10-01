@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- ====================================== --}}
{{-- JUDUL HALAMAN --}}
{{-- ====================================== --}}

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-900">

        Dashboard Admin

    </h1>

    <p class="mt-2 text-gray-500">

        Selamat datang,
        <span class="font-semibold">
            {{ auth()->user()->name }}
        </span>.

        Silakan pilih menu untuk mengelola data Kalurahan Pandowoharjo.

    </p>

</div>



{{-- ====================================== --}}
{{-- MENU UTAMA --}}
{{-- ====================================== --}}

<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">


    {{-- MANAGE DUKUH --}}

    <a
        href="{{ route('admin.dukuh') }}"
        class="group rounded-2xl
               border border-gray-200
               bg-white p-6 shadow-sm
               transition duration-300
               hover:-translate-y-1
               hover:shadow-lg"
    >

        <div
            class="mb-5 flex h-14 w-14
                   items-center justify-center
                   rounded-2xl bg-blue-100
                   text-2xl text-blue-600"
        >

            <i class="fa-solid fa-house"></i>

        </div>


        <h2 class="text-xl font-bold text-gray-900">

            Manage Dukuh

        </h2>


        <p class="mt-3 text-sm leading-relaxed text-gray-500">

            Mengelola seluruh data dukuh, termasuk
            informasi nama kepala dukuh dan alamat.

        </p>


        <div
            class="mt-6 flex items-center gap-2
                   text-sm font-semibold text-green-700"
        >

            Kelola Dukuh

            <i
                class="fa-solid fa-arrow-right
                       transition group-hover:translate-x-1"
            ></i>

        </div>

    </a>



    {{-- MANAGE AGENDA --}}

    <a
        href="{{ route('admin.agenda') }}"
        class="group rounded-2xl
               border border-gray-200
               bg-white p-6 shadow-sm
               transition duration-300
               hover:-translate-y-1
               hover:shadow-lg"
    >

        <div
            class="mb-5 flex h-14 w-14
                   items-center justify-center
                   rounded-2xl bg-green-100
                   text-2xl text-green-600"
        >

            <i class="fa-solid fa-calendar-days"></i>

        </div>


        <h2 class="text-xl font-bold text-gray-900">

            Manage Agenda

        </h2>


        <p class="mt-3 text-sm leading-relaxed text-gray-500">

            Menambahkan, memperbarui, dan menghapus
            agenda beserta dokumentasi foto.

        </p>


        <div
            class="mt-6 flex items-center gap-2
                   text-sm font-semibold text-green-700"
        >

            Kelola Agenda

            <i
                class="fa-solid fa-arrow-right
                       transition group-hover:translate-x-1"
            ></i>

        </div>

    </a>



    {{-- MANAGE KEGIATAN --}}

    <a
        href="{{ route('admin.kegiatan') }}"
        class="group rounded-2xl
               border border-gray-200
               bg-white p-6 shadow-sm
               transition duration-300
               hover:-translate-y-1
               hover:shadow-lg"
    >

        <div
            class="mb-5 flex h-14 w-14
                   items-center justify-center
                   rounded-2xl bg-orange-100
                   text-2xl text-orange-600"
        >

            <i class="fa-solid fa-people-group"></i>

        </div>


        <h2 class="text-xl font-bold text-gray-900">

            Manage Kegiatan

        </h2>


        <p class="mt-3 text-sm leading-relaxed text-gray-500">

            Mengelola realisasi agenda, kegiatan
            insidental, dan dokumentasi foto kegiatan.

        </p>


        <div
            class="mt-6 flex items-center gap-2
                   text-sm font-semibold text-green-700"
        >

            Kelola Kegiatan

            <i
                class="fa-solid fa-arrow-right
                       transition group-hover:translate-x-1"
            ></i>

        </div>

    </a>


</div>

@endsection