@extends('layouts.admin')

@section('title', 'Manage Dukuh')

@section('content')

{{-- HEADER HALAMAN --}}

<div class="mb-6 flex flex-col gap-4
            sm:flex-row sm:items-center sm:justify-between">

    <div>

        <h1 class="text-3xl font-bold text-gray-900">
            Manage Dukuh
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola data dukuh Kalurahan Pandowoharjo.
        </p>

    </div>


    <a
        href="{{ route('admin.dukuh.form') }}"
        class="inline-flex items-center justify-center
               gap-2 rounded-xl bg-green-600
               px-5 py-3 text-sm font-semibold
               text-white transition hover:bg-green-700"
    >

        <i class="fa-solid fa-plus"></i>

        Tambah Dukuh

    </a>

</div>



{{-- SEARCH --}}

@include('admin.dukuh.search')


        {{-- CARD --}}
        <div
            class="overflow-hidden rounded-2xl
                   border border-gray-200
                   bg-white shadow-sm"
        >

            {{-- INFORMASI JUMLAH DATA --}}
            <div
                class="flex flex-col gap-2 border-b
                       border-gray-200 px-6 py-4
                       sm:flex-row sm:items-center
                       sm:justify-between"
            >
                <div>
                    <h2 class="font-bold text-gray-900">
                        Daftar Dukuh
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Total {{ $dukuh->total() }} data dukuh
                    </p>
                </div>

                <p class="text-sm text-gray-500">
                    Menampilkan
                    {{ $dukuh->firstItem() ?? 0 }}
                    -
                    {{ $dukuh->lastItem() ?? 0 }}
                    dari
                    {{ $dukuh->total() }}
                    data
                </p>
            </div>


            {{-- JIKA DATA KOSONG --}}
            @if ($dukuh->isEmpty())

                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto mb-4 flex h-16 w-16
                               items-center justify-center
                               rounded-full bg-gray-100
                               text-2xl text-gray-400"
                    >
                        <i class="fa-solid fa-house"></i>
                    </div>

                    <h3 class="font-semibold text-gray-800">
                        Belum Ada Data Dukuh
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Silakan tambahkan data dukuh terlebih dahulu.
                    </p>

                </div>

            @else

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>
                                <th
                                    class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           uppercase tracking-wider
                                           text-gray-500"
                                >
                                    No
                                </th>

                                <th
                                    class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           uppercase tracking-wider
                                           text-gray-500"
                                >
                                    Nama Dukuh
                                </th>

                                <th
                                    class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           uppercase tracking-wider
                                           text-gray-500"
                                >
                                    Kepala Dukuh
                                </th>

                                <th
                                    class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           uppercase tracking-wider
                                           text-gray-500"
                                >
                                    Alamat
                                </th>

                                <th
                                    class="px-6 py-4 text-center
                                           text-xs font-semibold
                                           uppercase tracking-wider
                                           text-gray-500"
                                >
                                    Aksi
                                </th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100 bg-white">

                            @foreach ($dukuh as $item)

                                <tr class="transition hover:bg-gray-50">

                                    {{-- NOMOR --}}
                                    <td
                                        class="whitespace-nowrap
                                               px-6 py-4 text-sm
                                               text-gray-500"
                                    >
                                        {{ $dukuh->firstItem() + $loop->index }}
                                    </td>


                                    {{-- NAMA DUKUH --}}
                                    <td
                                        class="whitespace-nowrap
                                               px-6 py-4"
                                    >
                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-9 w-9
                                                       items-center justify-center
                                                       rounded-lg bg-green-100
                                                       text-green-600"
                                            >
                                                <i class="fa-solid fa-house"></i>
                                            </div>

                                            <span
                                                class="font-semibold
                                                       text-gray-800"
                                            >
                                                {{ $item->nama_dukuh }}
                                            </span>

                                        </div>
                                    </td>


                                    {{-- KEPALA DUKUH --}}
                                    <td class="px-6 py-4 text-sm text-gray-600">

                                        {{ $item->nama_kepala_dukuh ?? '-' }}

                                    </td>


                                    {{-- ALAMAT --}}
                                    <td class="px-6 py-4 text-sm text-gray-600">

                                        {{ $item->alamat ?? '-' }}

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('admin.dukuh.edit', $item->id) }}"
                                                class="rounded-lg
                                                    bg-blue-50
                                                    px-3 py-2
                                                    text-sm font-semibold
                                                    text-blue-600
                                                    transition
                                                    hover:bg-blue-100"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </a>


                                            {{-- DELETE --}}
                                            <form
                                                action="{{ route('admin.dukuh.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data dukuh ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg
                                                        bg-red-50
                                                        px-3 py-2
                                                        text-sm font-semibold
                                                        text-red-600
                                                        transition
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
                <div
                    class="border-t border-gray-200
                           px-6 py-5"
                >

                    {{ $dukuh->links() }}

                </div>

            @endif

        </div>

    
@endsection