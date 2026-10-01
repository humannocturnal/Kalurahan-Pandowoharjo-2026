@php


    $editing = isset($kegiatan);

    // Apakah formulir berasal dari realisasi agenda?

    $isRealization = isset($sourceAgenda);
    


    // ==================================
    // DUKUH
    // ==================================

    $selectedDukuh = $isRealization
        ? $sourceAgenda->dukuh_id
        : old(
            'dukuh_id',
            $editing ? $kegiatan->dukuh_id : ''
        );


    // ==================================
    // AGENDA
    // ==================================

    $selectedAgenda = $isRealization
        ? $sourceAgenda->id
        : old(
            'agenda_id',
            $editing ? $kegiatan->agenda_id : ''
        );


    // ==================================
    // DATA DEFAULT
    // ==================================

    $defaultJudul = $isRealization
        ? $sourceAgenda->judul
        : ($editing ? $kegiatan->judul : '');


    $defaultTanggal = $isRealization
        ? $sourceAgenda->tanggal->format('Y-m-d')
        : (
            $editing
                ? $kegiatan->tanggal->format('Y-m-d')
                : ''
        );


    $defaultLokasi = $isRealization
        ? $sourceAgenda->lokasi
        : ($editing ? $kegiatan->lokasi : '');

@endphp



{{-- NAMA DUKUH --}}

{{-- DUKUH --}}

<div>

    <label
        for="dukuh_id"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >

        Dukuh <span class="text-red-500">*</span>

    </label>


    <select
        name="dukuh_id"
        id="dukuh_id"
        required
        @disabled($isRealization)
        class="w-full rounded-xl border border-gray-300
               bg-white px-4 py-3
               focus:border-green-500
               disabled:cursor-not-allowed
               disabled:bg-gray-100"
    >

        <option value="">
            -- Pilih Dukuh --
        </option>


        @foreach ($dukuh as $item)

            <option
                value="{{ $item->id }}"
                @selected($selectedDukuh == $item->id)
            >

                {{ $item->nama_dukuh }}

            </option>

        @endforeach

    </select>


    @if ($isRealization)

        <input
            type="hidden"
            name="dukuh_id"
            value="{{ $sourceAgenda->dukuh_id }}"
        >

    @endif


    @error('dukuh_id')

        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>

    @enderror

</div>


{{-- AGENDA ASAL --}}

{{-- AGENDA ASAL --}}

<div>

    <label
        for="agenda_id"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >

        Agenda Asal

    </label>


    <select
        name="agenda_id"
        id="agenda_id"
        @disabled($isRealization)
        class="w-full rounded-xl border border-gray-300
               bg-white px-4 py-3
               focus:border-green-500
               disabled:cursor-not-allowed
               disabled:bg-gray-100"
    >

        <option value="">
            -- Kegiatan Insidental / Tanpa Agenda --
        </option>


        @foreach ($agenda as $item)

            <option
                value="{{ $item->id }}"
                data-dukuh="{{ $item->dukuh_id }}"
                @selected($selectedAgenda == $item->id)
            >

                {{ $item->judul }}

                ({{ $item->tanggal->format('d-m-Y') }})

            </option>

        @endforeach

    </select>


    @if ($isRealization)

        <input
            type="hidden"
            name="agenda_id"
            value="{{ $sourceAgenda->id }}"
        >

        <p class="mt-2 text-xs text-green-700">

            <i class="fa-solid fa-circle-info mr-1"></i>

            Kegiatan ini merupakan realisasi dari agenda yang dipilih.

        </p>

    @else

        <p class="mt-2 text-xs text-gray-500">

            Kosongkan jika kegiatan tidak berasal dari
            agenda yang sudah direncanakan.

        </p>

    @endif


    @error('agenda_id')

        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>

    @enderror

</div>


{{-- JUDUL --}}

<div>

    <label class="mb-2 block text-sm font-semibold text-gray-700">
        Judul Kegiatan <span class="text-red-500">*</span>
    </label>

    <input
        type="text"
        name="judul"
        value="{{ old('judul', $defaultJudul) }}"
        required
        class="w-full rounded-xl border border-gray-300
            px-4 py-3 focus:border-green-500"
    >

    @error('judul')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

</div>


{{-- DESKRIPSI --}}

<div>

    <label class="mb-2 block text-sm font-semibold text-gray-700">
        Deskripsi
    </label>

    <textarea
        name="deskripsi"
        rows="5"
        class="w-full rounded-xl border border-gray-300
               px-4 py-3 focus:border-green-500"
    >{{ old('deskripsi', $editing ? $kegiatan->deskripsi : '') }}</textarea>

    @error('deskripsi')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

</div>


{{-- TANGGAL --}}

<div>

    <label class="mb-2 block text-sm font-semibold text-gray-700">
        Tanggal Pelaksanaan <span class="text-red-500">*</span>
    </label>

    <input
        type="date"
        name="tanggal"
        value="{{ old('tanggal', $defaultTanggal) }}"
        required
        class="w-full rounded-xl border border-gray-300
            px-4 py-3 focus:border-green-500"
    >

    @error('tanggal')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

</div>


{{-- WAKTU --}}

<div class="grid gap-4 sm:grid-cols-2">

    <div>

        <label class="mb-2 block text-sm font-semibold text-gray-700">
            Waktu Mulai
        </label>

        <input
            type="time"
            name="waktu_mulai"
            value="{{ old(
                'waktu_mulai',
                $editing ? substr($kegiatan->waktu_mulai ?? '', 0, 5) : ''
            ) }}"
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 focus:border-green-500"
        >

    </div>


    <div>

        <label class="mb-2 block text-sm font-semibold text-gray-700">
            Waktu Selesai
        </label>

        <input
            type="time"
            name="waktu_selesai"
            value="{{ old(
                'waktu_selesai',
                $editing ? substr($kegiatan->waktu_selesai ?? '', 0, 5) : ''
            ) }}"
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 focus:border-green-500"
        >

    </div>

</div>

@error('waktu_mulai')
    <p class="text-sm text-red-600">{{ $message }}</p>
@enderror

@error('waktu_selesai')
    <p class="text-sm text-red-600">{{ $message }}</p>
@enderror


{{-- LOKASI --}}

<div>

    <label class="mb-2 block text-sm font-semibold text-gray-700">
        Lokasi
    </label>

    <input
        type="text"
        name="lokasi"
        value="{{ old('lokasi', $defaultLokasi) }}"
        class="w-full rounded-xl border border-gray-300
            px-4 py-3 focus:border-green-500"
    >

    @error('lokasi')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror

</div>


{{-- UPLOAD FOTO --}}

{{-- ========================================== --}}
{{-- UPLOAD DAN PREVIEW FOTO KEGIATAN --}}
{{-- ========================================== --}}

<div class="border-t border-gray-200 pt-6">

    <div class="mb-4">

        <h3 class="text-lg font-bold text-gray-900">
            Dokumentasi Kegiatan
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Pilih foto dokumentasi kegiatan.
            Foto akan ditampilkan sebelum disimpan.
        </p>

    </div>

    <x-upload-images
        name="fotos"
        :label="$editing ? 'Tambah Foto Kegiatan' : 'Upload Foto Kegiatan'"
        :max-size="5"
    />

</div>


{{-- FILTER AGENDA SESUAI DUKUH --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const dukuhSelect = document.getElementById('dukuh_id');
    const agendaSelect = document.getElementById('agenda_id');

    function filterAgenda() {

        const dukuhId = dukuhSelect.value;

        Array.from(agendaSelect.options).forEach(function(option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = option.dataset.dukuh !== dukuhId;

            if (option.hidden && option.selected) {
                agendaSelect.value = '';
            }

        });

    }

    dukuhSelect.addEventListener('change', function () {
        agendaSelect.value = '';
        filterAgenda();
    });

    filterAgenda();

});

</script>