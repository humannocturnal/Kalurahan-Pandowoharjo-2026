@extends('layouts.admin')

@section('title', 'Manage Kegiatan')

@section('content')

{{-- HEADER --}}

<div class="mb-6 flex flex-col gap-4
            sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-3xl font-bold text-gray-900">
            Manage Kegiatan
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Kelola realisasi agenda dan kegiatan insidental
            Kalurahan Pandowoharjo.
        </p>

    </div>

    <a
        href="{{ route('admin.kegiatan.form') }}"
        class="inline-flex items-center justify-center gap-2
               rounded-xl bg-green-600 px-5 py-3
               text-sm font-semibold text-white
               hover:bg-green-700"
    >
        <i class="fa-solid fa-plus"></i>
        Tambah Kegiatan
    </a>

</div>


{{-- SEARCH --}}

@include('admin.kegiatan.search')


{{-- TABEL --}}

<div class="overflow-hidden rounded-2xl
            border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-2 border-b
                border-gray-200 px-6 py-5
                sm:flex-row sm:items-center
                sm:justify-between">

        <div>

            <h2 class="font-bold text-gray-900">
                Daftar Kegiatan
            </h2>

            @if (request('search'))

                <p class="mt-1 text-sm text-gray-500">

                    Hasil pencarian "{{ request('search') }}"

                    — {{ $kegiatan->total() }} data ditemukan.

                </p>

            @else

                <p class="mt-1 text-sm text-gray-500">
                    Total {{ $kegiatan->total() }} kegiatan.
                </p>

            @endif

        </div>

        <p class="text-sm text-gray-500">

            Menampilkan
            {{ $kegiatan->firstItem() ?? 0 }}
            -
            {{ $kegiatan->lastItem() ?? 0 }}

            dari {{ $kegiatan->total() }} data

        </p>

    </div>


    @if ($kegiatan->isEmpty())

        <div class="px-6 py-16 text-center">

            <i class="fa-solid fa-people-group
                      mb-4 text-5xl text-gray-300"></i>

            <h3 class="font-semibold text-gray-800">
                Data Kegiatan Tidak Ditemukan
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Belum ada kegiatan yang sesuai.
            </p>

        </div>

    @else

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-4 text-left text-xs
                                   font-semibold uppercase text-gray-500">
                            No
                        </th>

                        <th class="px-5 py-4 text-left text-xs
                                   font-semibold uppercase text-gray-500">
                            Kegiatan
                        </th>

                        <th class="px-5 py-4 text-left text-xs
                                   font-semibold uppercase text-gray-500">
                            Dukuh
                        </th>

                        <th class="px-5 py-4 text-left text-xs
                                   font-semibold uppercase text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-left text-xs
                                   font-semibold uppercase text-gray-500">
                            Jenis
                        </th>

                        <th class="px-5 py-4 text-center text-xs
                                   font-semibold uppercase text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($kegiatan as $item)

                        <tr class="hover:bg-gray-50">

                            {{-- NOMOR --}}

                            <td class="px-5 py-4 text-sm text-gray-500">

                                {{ $kegiatan->firstItem() + $loop->index }}

                            </td>


                            {{-- KEGIATAN --}}

                            <td class="px-5 py-4">

                                <p class="font-semibold text-gray-800">
                                    {{ $item->judul }}
                                </p>

                                <p class="mt-1 max-w-xs truncate
                                          text-xs text-gray-500">

                                    {{ $item->deskripsi ?: '-' }}

                                </p>

                            </td>


                            {{-- DUKUH --}}

                            <td class="px-5 py-4 text-sm text-gray-600">

                                {{ $item->dukuh->nama_dukuh ?? '-' }}

                            </td>


                            {{-- TANGGAL --}}

                            <td class="whitespace-nowrap px-5 py-4
                                       text-sm text-gray-600">

                                {{ $item->tanggal
                                    ->locale('id')
                                    ->translatedFormat('d M Y') }}

                            </td>


                            {{-- JENIS KEGIATAN --}}

                            <td class="px-5 py-4">

                                @if ($item->agenda)

                                    <span class="inline-flex rounded-full
                                                 bg-green-100 px-3 py-1
                                                 text-xs font-semibold
                                                 text-green-700">

                                        Realisasi Agenda

                                    </span>

                                @else

                                    <span class="inline-flex rounded-full
                                                 bg-orange-100 px-3 py-1
                                                 text-xs font-semibold
                                                 text-orange-700">

                                        Insidental

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="px-5 py-4">

                                <div class="flex items-center
                                            justify-center gap-2">

                                    {{-- DETAIL --}}

                                    <a
                                        href="{{ route('admin.kegiatan.show', $item->id) }}"
                                        title="Lihat Detail"
                                        class="rounded-lg bg-green-50
                                               px-3 py-2 text-green-600
                                               hover:bg-green-100"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('admin.kegiatan.edit', $item->id) }}"
                                        title="Edit Kegiatan"
                                        class="rounded-lg bg-blue-50
                                               px-3 py-2 text-blue-600
                                               hover:bg-blue-100"
                                    >

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('admin.kegiatan.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini beserta seluruh fotonya?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus Kegiatan"
                                            class="rounded-lg bg-red-50
                                                   px-3 py-2 text-red-600
                                                   hover:bg-red-100"
                                        >

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        <div class="border-t border-gray-200 px-6 py-5">

            {{ $kegiatan->links() }}

        </div>

    @endif

</div>

@endsection