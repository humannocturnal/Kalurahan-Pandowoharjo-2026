@php
    $editing = isset($agenda);

    $selectedDukuh = old(
        'dukuh_id',
        $editing ? $agenda->dukuh_id : ''
    );

    $selectedStatus = old(
        'status',
        $editing ? $agenda->status : 'direncanakan'
    );
@endphp


{{-- ========================================== --}}
{{-- DUKUH --}}
{{-- ========================================== --}}

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
        class="w-full rounded-xl border border-gray-300
               bg-white px-4 py-3 outline-none
               transition focus:border-green-500
               focus:ring-2 focus:ring-green-100"
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

    @error('dukuh_id')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- JUDUL --}}
{{-- ========================================== --}}

<div>

    <label
        for="judul"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >
        Judul Agenda <span class="text-red-500">*</span>
    </label>

    <input
        type="text"
        name="judul"
        id="judul"
        value="{{ old('judul', $editing ? $agenda->judul : '') }}"
        required
        placeholder="Masukkan judul agenda"
        class="w-full rounded-xl border border-gray-300
               px-4 py-3 outline-none transition
               focus:border-green-500
               focus:ring-2 focus:ring-green-100"
    >

    @error('judul')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- DESKRIPSI --}}
{{-- ========================================== --}}

<div>

    <label
        for="deskripsi"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >
        Deskripsi Agenda
    </label>

    <textarea
        name="deskripsi"
        id="deskripsi"
        rows="5"
        placeholder="Masukkan deskripsi agenda"
        class="w-full rounded-xl border border-gray-300
               px-4 py-3 outline-none transition
               focus:border-green-500
               focus:ring-2 focus:ring-green-100"
    >{{ old('deskripsi', $editing ? $agenda->deskripsi : '') }}</textarea>

    @error('deskripsi')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- TANGGAL --}}
{{-- ========================================== --}}

<div>

    <label
        for="tanggal"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >
        Tanggal Agenda <span class="text-red-500">*</span>
    </label>

    <input
        type="date"
        name="tanggal"
        id="tanggal"
        value="{{ old(
            'tanggal',
            $editing
                ? \Carbon\Carbon::parse($agenda->tanggal)->format('Y-m-d')
                : ''
        ) }}"
        required
        class="w-full rounded-xl border border-gray-300
               px-4 py-3 outline-none transition
               focus:border-green-500
               focus:ring-2 focus:ring-green-100"
    >

    @error('tanggal')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- WAKTU --}}
{{-- ========================================== --}}

<div class="grid gap-5 sm:grid-cols-2">

    {{-- WAKTU MULAI --}}

    <div>

        <label
            for="waktu_mulai"
            class="mb-2 block text-sm font-semibold text-gray-700"
        >
            Waktu Mulai <span class="text-red-500">*</span>
        </label>

        <input
            type="time"
            name="waktu_mulai"
            id="waktu_mulai"
            value="{{ old(
                'waktu_mulai',
                $editing ? substr($agenda->waktu_mulai ?? '', 0, 5) : ''
            ) }}"
            required
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 outline-none transition
                   focus:border-green-500
                   focus:ring-2 focus:ring-green-100"
        >

        @error('waktu_mulai')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- WAKTU SELESAI --}}

    <div>

        <label
            for="waktu_selesai"
            class="mb-2 block text-sm font-semibold text-gray-700"
        >
            Waktu Selesai <span class="text-red-500">*</span>
        </label>

        <input
            type="time"
            name="waktu_selesai"
            id="waktu_selesai"
            value="{{ old(
                'waktu_selesai',
                $editing ? substr($agenda->waktu_selesai ?? '', 0, 5) : ''
            ) }}"
            required
            class="w-full rounded-xl border border-gray-300
                   px-4 py-3 outline-none transition
                   focus:border-green-500
                   focus:ring-2 focus:ring-green-100"
        >

        @error('waktu_selesai')
            <p class="mt-2 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>

</div>


{{-- ========================================== --}}
{{-- LOKASI --}}
{{-- ========================================== --}}

<div>

    <label
        for="lokasi"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >
        Lokasi Agenda <span class="text-red-500">*</span>
    </label>

    <input
        type="text"
        name="lokasi"
        id="lokasi"
        value="{{ old('lokasi', $editing ? $agenda->lokasi : '') }}"
        required
        placeholder="Masukkan lokasi agenda"
        class="w-full rounded-xl border border-gray-300
               px-4 py-3 outline-none transition
               focus:border-green-500
               focus:ring-2 focus:ring-green-100"
    >

    @error('lokasi')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- STATUS --}}
{{-- ========================================== --}}

<div>

    <label
        for="status"
        class="mb-2 block text-sm font-semibold text-gray-700"
    >
        Status Agenda <span class="text-red-500">*</span>
    </label>

    <select
        name="status"
        id="status"
        required
        class="w-full rounded-xl border border-gray-300
               bg-white px-4 py-3 outline-none
               transition focus:border-green-500
               focus:ring-2 focus:ring-green-100"
    >

        <option
            value="direncanakan"
            @selected($selectedStatus === 'direncanakan')
        >
            Direncanakan
        </option>

        <option
            value="selesai"
            @selected($selectedStatus === 'selesai')
        >
            Selesai
        </option>

        <option
            value="dibatalkan"
            @selected($selectedStatus === 'dibatalkan')
        >
            Dibatalkan
        </option>

    </select>

    @error('status')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

</div>


{{-- ========================================== --}}
{{-- UPLOAD DAN PREVIEW FOTO --}}
{{-- ========================================== --}}

<div class="border-t border-gray-200 pt-6">

    <h3 class="mb-4 text-lg font-bold text-gray-900">
        Dokumentasi Agenda
    </h3>

    <x-upload-images
        name="fotos"
        :label="$editing ? 'Tambah Foto Agenda' : 'Upload Foto Agenda'"
        :max-size="5"
    />

</div>