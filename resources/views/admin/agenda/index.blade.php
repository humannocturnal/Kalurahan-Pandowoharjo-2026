@extends('layouts.admin')

@section('title', 'Manage Agenda')

@section('content')

{{-- HEADER HALAMAN --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            Manage Agenda
        </h1>

        <p class="mt-2 text-sm text-gray-500">
            Kelola seluruh agenda Kalurahan Pandowoharjo.
        </p>
    </div>

    <a
        href="{{ route('admin.agenda.form') }}"
        class="inline-flex items-center justify-center gap-2
               rounded-xl bg-green-600 px-5 py-3
               text-sm font-semibold text-white
               transition hover:bg-green-700"
    >
        <i class="fa-solid fa-plus"></i>
        Tambah Agenda
    </a>

</div>


{{-- SEARCH --}}
@include('admin.agenda.search')


{{-- TABEL AGENDA --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- INFORMASI JUMLAH DATA --}}
    <div class="flex flex-col gap-2 border-b border-gray-200
                px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="font-bold text-gray-900">
                Daftar Agenda
            </h2>

            @if (request('search'))

                <p class="mt-1 text-sm text-gray-500">
                    Hasil pencarian
                    <span class="font-semibold">
                        "{{ request('search') }}"
                    </span>

                    — ditemukan {{ $agenda->total() }} data.
                </p>

            @else

                <p class="mt-1 text-sm text-gray-500">
                    Total {{ $agenda->total() }} agenda.
                </p>

            @endif
        </div>

        <p class="text-sm text-gray-500">
            Menampilkan
            {{ $agenda->firstItem() ?? 0 }}
            -
            {{ $agenda->lastItem() ?? 0 }}
            dari
            {{ $agenda->total() }}
            data
        </p>

    </div>


    {{-- DATA KOSONG --}}
    @if ($agenda->isEmpty())

        <div class="px-6 py-16 text-center">

            <div class="mx-auto mb-4 flex h-16 w-16
                        items-center justify-center
                        rounded-full bg-gray-100
                        text-2xl text-gray-400">

                <i class="fa-solid fa-calendar-xmark"></i>

            </div>

            <h3 class="font-semibold text-gray-800">
                Data Agenda Tidak Ditemukan
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Belum terdapat agenda yang sesuai.
            </p>

        </div>

    @else

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            No
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            Agenda
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            Dukuh
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            Waktu
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                            Lokasi
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                            Status
                        </th>

                        <th class="px-5 py-4 text-center text-xs font-semibold uppercase text-gray-500">
                            Aksi
                        </th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($agenda as $item)

                        <tr class="transition hover:bg-gray-50">

                            {{-- NOMOR --}}
                            <td class="px-5 py-4 text-sm text-gray-500">
                                {{ $agenda->firstItem() + $loop->index }}
                            </td>


                            {{-- JUDUL --}}
                            <td class="px-5 py-4">

                                <p class="font-semibold text-gray-800">
                                    {{ $item->judul }}
                                </p>

                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                    {{ $item->deskripsi }}
                                </p>

                            </td>


                            {{-- DUKUH --}}
                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $item->dukuh->nama_dukuh ?? '-' }}
                            </td>


                            {{-- TANGGAL --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">

                                {{ $item->tanggal
                                    ->locale('id')
                                    ->translatedFormat('d M Y') }}

                            </td>


                            {{-- WAKTU --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">

                                {{ substr($item->waktu_mulai, 11, 5) }}
                                -
                                {{ substr($item->waktu_selesai, 11, 5) }}

                            </td>


                            {{-- LOKASI --}}
                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $item->lokasi }}
                            </td>


                            {{-- STATUS --}}
                            <td class="px-5 py-4 text-center">

                                @if ($item->status === 'direncanakan')

                                    <span class="inline-flex rounded-full
                                                 bg-blue-100 px-3 py-1
                                                 text-xs font-semibold text-blue-700">
                                        Direncanakan
                                    </span>

                                @elseif ($item->status === 'selesai')

                                    <span class="inline-flex rounded-full
                                                 bg-green-100 px-3 py-1
                                                 text-xs font-semibold text-green-700">
                                        Selesai
                                    </span>

                                @elseif ($item->status === 'dibatalkan')

                                    <span class="inline-flex rounded-full
                                                 bg-red-100 px-3 py-1
                                                 text-xs font-semibold text-red-700">
                                        Dibatalkan
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full
                                                 bg-gray-100 px-3 py-1
                                                 text-xs font-semibold text-gray-700">

                                        {{ ucfirst($item->status) }}

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('admin.agenda.show', $item->id) }}"
                                        title="Lihat Detail"
                                        class="rounded-lg bg-green-50
                                               px-3 py-2 text-green-600
                                               transition hover:bg-green-100"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.agenda.edit', $item->id) }}"
                                        title="Edit Agenda"
                                        class="rounded-lg bg-blue-50
                                               px-3 py-2 text-blue-600
                                               transition hover:bg-blue-100"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('admin.agenda.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus agenda ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus Agenda"
                                            class="rounded-lg bg-red-50
                                                   px-3 py-2 text-red-600
                                                   transition hover:bg-red-100"
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

            {{ $agenda->links() }}

        </div>

    @endif

</div>

@endsection