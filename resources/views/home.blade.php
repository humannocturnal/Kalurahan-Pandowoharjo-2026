@extends('layouts.pengunjung')

@push('styles')

<script
    src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.21/index.global.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.21/locales-all.global.min.js">
</script>

<style>

    /*
    |--------------------------------------------------------------------------
    | FULLCALENDAR HOME
    |--------------------------------------------------------------------------
    */

    #homeCalendar {
        font-size: 11px;
    }


    #homeCalendar .fc-toolbar-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    #homeCalendar .fc-toolbar {
        margin-bottom: 12px;
    }


    #homeCalendar .fc-button {
        font-size: 16px;
        font-weight: 700;
        padding: 4px 10px;
    }


    #homeCalendar .fc-col-header-cell-cushion {
        font-size: 10px;
        font-weight: 600;
        color: #4b5563;
    }


    #homeCalendar .fc-daygrid-day-number {
        padding: 4px;
        font-size: 10px;
        color: #374151;
    }


    #homeCalendar .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 1px 2px;
        font-size: 9px;
    }


    #homeCalendar .fc-day-today {
        background: #f0fdf4 !important;
    }


    #homeCalendar a {
        text-decoration: none;
    }

</style>

@endpush

@section('title', 'Home - Kalurahan Pandowoharjo')

@section('content')

{{-- ================================================= --}}
{{-- HERO / SELAMAT DATANG --}}
{{-- ================================================= --}}

<section class="bg-gradient-to-b from-green-50 to-gray-50 py-14 sm:py-10">

    <div class="mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mx-auto text-center">

                {{-- ========================================== --}}
                {{-- HERO + KALENDER --}}
                {{-- ========================================== --}}

                <section class="mb-5">

                    <div class="grid gap-6 xl:grid-cols-3">


                    {{-- ====================================== --}}
                    {{-- HERO CAROUSEL - 2/3 --}}
                    {{-- ====================================== --}}

                    <div
                        id="heroCarousel"
                        class="relative min-h-[480px] overflow-hidden
                            rounded-3xl shadow-lg xl:col-span-2"
                    >

                        {{-- SLIDE 1 --}}
                        <div
                            class="hero-slide absolute inset-0 opacity-100
                                transition-opacity duration-700"
                            data-slide
                        >
                            <img
                                src="{{ asset('images/hero/slide1.jpg') }}"
                                alt="Kalurahan Pandowoharjo"
                                class="absolute inset-0 h-full w-full object-cover"
                            >

                            <div
                                class="absolute inset-0
                                    bg-gradient-to-r
                                    from-black/75 via-black/50
                                    to-black/20"
                            ></div>

                            <div
                                class="relative z-10 flex min-h-[480px]
                                    items-center px-8 py-12 sm:px-12"
                            >
                                <div class="max-w-2xl text-left text-white">

                                    <span
                                        class="inline-flex items-center gap-2
                                            rounded-full bg-white/15
                                            px-4 py-2 text-sm font-semibold
                                            backdrop-blur"
                                    >
                                        <i class="fa-solid fa-building-columns"></i>
                                        Sistem Informasi Kalurahan
                                    </span>

                                    <h1
                                        class="mt-5 text-3xl font-bold
                                            leading-tight sm:text-4xl lg:text-5xl"
                                    >
                                        Selamat Datang di Kalurahan Pandowoharjo
                                    </h1>

                                    <p
                                        class="mt-5 max-w-xl text-sm
                                            leading-7 text-gray-100 sm:text-base"
                                    >
                                        Temukan informasi agenda dan kegiatan
                                        yang dilaksanakan di wilayah
                                        Kalurahan Pandowoharjo.
                                    </p>

                                </div>
                            </div>
                        </div>


                        {{-- SLIDE 2 --}}
                        <div
                            class="hero-slide absolute inset-0 opacity-0
                                transition-opacity duration-700"
                            data-slide
                        >
                            <img
                                src="{{ asset('images/hero/slide2.jpg') }}"
                                alt="Agenda Kalurahan"
                                class="absolute inset-0 h-full w-full object-cover"
                            >

                            <div
                                class="absolute inset-0
                                    bg-gradient-to-r
                                    from-black/75 via-black/45
                                    to-black/20"
                            ></div>

                            <div
                                class="relative z-10 flex min-h-[480px]
                                    items-center px-8 py-12 sm:px-12"
                            >
                                <div class="max-w-2xl text-left text-white">

                                    <span
                                        class="inline-flex items-center gap-2
                                            rounded-full bg-green-600/80
                                            px-4 py-2 text-sm font-semibold"
                                    >
                                        <i class="fa-solid fa-calendar-days"></i>
                                        Agenda Kalurahan
                                    </span>

                                    <h2
                                        class="mt-5 text-3xl font-bold
                                            leading-tight sm:text-4xl lg:text-5xl"
                                    >
                                        Ikuti Agenda di Lingkungan Kalurahan
                                    </h2>

                                    <p
                                        class="mt-5 max-w-xl text-sm
                                            leading-7 text-gray-100 sm:text-base"
                                    >
                                        Dapatkan informasi jadwal, lokasi,
                                        dan pelaksanaan agenda masyarakat
                                        secara mudah.
                                    </p>

                                </div>
                            </div>
                        </div>


                        {{-- SLIDE 3 --}}
                        <div
                            class="hero-slide absolute inset-0 opacity-0
                                transition-opacity duration-700"
                            data-slide
                        >
                            <img
                                src="{{ asset('images/hero/slide3.jpg') }}"
                                alt="Kegiatan Kalurahan"
                                class="absolute inset-0 h-full w-full object-cover"
                            >

                            <div
                                class="absolute inset-0
                                    bg-gradient-to-r
                                    from-black/75 via-black/45
                                    to-black/20"
                            ></div>

                            <div
                                class="relative z-10 flex min-h-[480px]
                                    items-center px-8 py-12 sm:px-12"
                            >
                                <div class="max-w-2xl text-left text-white">

                                    <span
                                        class="inline-flex items-center gap-2
                                            rounded-full bg-orange-600/90
                                            px-4 py-2 text-sm font-semibold"
                                    >
                                        <i class="fa-solid fa-people-group"></i>
                                        Kegiatan Kalurahan
                                    </span>

                                    <h2
                                        class="mt-5 text-3xl font-bold
                                            leading-tight sm:text-4xl lg:text-5xl"
                                    >
                                        Dokumentasi Kegiatan Masyarakat
                                    </h2>

                                    <p
                                        class="mt-5 max-w-xl text-sm
                                            leading-7 text-gray-100 sm:text-base"
                                    >
                                        Lihat berbagai kegiatan yang telah
                                        dilaksanakan di wilayah
                                        Kalurahan Pandowoharjo.
                                    </p>

                                </div>
                            </div>
                        </div>


                        {{-- PREVIOUS --}}
                        <button
                            type="button"
                            id="heroPrev"
                            class="absolute left-4 top-1/2 z-20
                                flex h-11 w-11 -translate-y-1/2
                                items-center justify-center
                                rounded-full bg-black/30
                                text-white backdrop-blur
                                transition hover:bg-black/50"
                            aria-label="Slide sebelumnya"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>


                        {{-- NEXT --}}
                        <button
                            type="button"
                            id="heroNext"
                            class="absolute right-4 top-1/2 z-20
                                flex h-11 w-11 -translate-y-1/2
                                items-center justify-center
                                rounded-full bg-black/30
                                text-white backdrop-blur
                                transition hover:bg-black/50"
                            aria-label="Slide berikutnya"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>


                        {{-- DOTS --}}
                        <div
                            id="heroDots"
                            class="absolute bottom-5 left-1/2 z-20
                                flex -translate-x-1/2 gap-2"
                        >
                            <button
                                type="button"
                                data-dot="0"
                                class="hero-dot h-2.5 w-8 rounded-full bg-white"
                            ></button>

                            <button
                                type="button"
                                data-dot="1"
                                class="hero-dot h-2.5 w-2.5 rounded-full bg-white/50"
                            ></button>

                            <button
                                type="button"
                                data-dot="2"
                                class="hero-dot h-2.5 w-2.5 rounded-full bg-white/50"
                            ></button>
                        </div>

                    </div>



                    {{-- ====================================== --}}
                    {{-- FULLCALENDAR - 1/3 --}}
                    {{-- ====================================== --}}

                    <div
                        class="rounded-3xl border
                            border-gray-200
                            bg-white p-5 shadow-sm"
                    >

                        <div class="mb-4">

                            <div class="mb-4 text-center">

                                <div
                                    class="mx-auto mb-3 flex h-12 w-12
                                        items-center justify-center
                                        rounded-2xl bg-green-100
                                        text-green-700"
                                >
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Agenda & kegiatan bulan ini
                                </p>

                            </div>

                        </div>


                        {{-- LEGENDA --}}

                        <div
                            class="mb-4 flex flex-wrap
                                items-center gap-4
                                border-y border-gray-100
                                py-3 text-xs"
                        >

                            <div class="flex items-center gap-2">

                                <span
                                    class="h-3 w-3 rounded-full
                                        bg-green-600"
                                ></span>

                                <span class="text-gray-600">
                                    Agenda
                                </span>

                            </div>


                            <div class="flex items-center gap-2">

                                <span
                                    class="h-3 w-3 rounded-full
                                        bg-orange-600"
                                ></span>

                                <span class="text-gray-600">
                                    Kegiatan
                                </span>

                            </div>

                        </div>


                        {{-- CALENDAR --}}

                        <div id="homeCalendar"></div>

                    </div>

                </div>

            </section>

            

            <p
                class="mx-auto mt-6 max-w-2xl
                       text-base leading-relaxed
                       text-gray-600 sm:text-lg"
            >

            </p>

        </div>

    </div>

</section>


{{-- ================================================= --}}
{{-- 5 AGENDA TERDEKAT --}}
{{-- ================================================= --}}

<section class="bg-white py-14 sm:py-10">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}

        <div
            class="mb-8 flex flex-col gap-4
                   sm:flex-row sm:items-end
                   sm:justify-between"
        >

            <div>

                <div
                    class="mb-3 inline-flex items-center gap-2
                           rounded-full bg-green-100
                           px-3 py-1 text-xs font-semibold
                           text-green-700"
                >

                    <i class="fa-regular fa-calendar"></i>

                    Agenda Mendatang

                </div>

                <h2
                    class="text-2xl font-bold
                           text-gray-900 sm:text-3xl"
                >

                    5 Agenda Terdekat

                </h2>

                <p class="mt-2 text-sm text-gray-500">

                    Informasi agenda yang akan segera dilaksanakan.

                </p>

            </div>

            <a
                href="{{ route('agenda.index') }}"
                class="inline-flex items-center gap-2
                       text-sm font-semibold text-green-700
                       transition hover:text-green-900"
            >

                Semua Agenda

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        {{-- DATA AGENDA --}}

        @if ($agenda->isEmpty())

            <div
                class="rounded-2xl border
                       border-dashed border-gray-300
                       bg-gray-50 px-6 py-14 text-center"
            >

                <i
                    class="fa-regular fa-calendar-xmark
                           mb-4 text-5xl text-gray-300"
                ></i>

                <h3 class="font-semibold text-gray-700">

                    Belum Ada Agenda Mendatang

                </h3>

                <p class="mt-2 text-sm text-gray-500">

                    Saat ini belum ada agenda yang dijadwalkan.

                </p>

            </div>

        @else

            <div
                class="grid gap-6
                       sm:grid-cols-2 lg:grid-cols-3"
            >

                @foreach ($agenda as $item)

                    <article
                        class="group flex h-full flex-col
                               overflow-hidden rounded-2xl
                               border border-gray-200
                               bg-white shadow-sm
                               transition duration-300
                               hover:-translate-y-1
                               hover:shadow-lg"
                    >

                        {{-- FOTO AGENDA --}}

                        <div
                            class="relative h-48
                                   overflow-hidden bg-green-50"
                        >

                            @if ($item->fotos->isNotEmpty())

                                <img
                                    src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                                    alt="{{ $item->judul }}"
                                    class="h-full w-full object-cover
                                           transition duration-500
                                           group-hover:scale-105"
                                >

                            @else

                                <div
                                    class="flex h-full w-full
                                           flex-col items-center
                                           justify-center
                                           bg-gradient-to-br
                                           from-green-100 to-green-50
                                           text-green-600"
                                >

                                    <i
                                        class="fa-solid fa-calendar-days
                                               mb-3 text-5xl"
                                    ></i>

                                    <span class="text-sm font-semibold">

                                        Agenda Kalurahan

                                    </span>

                                </div>

                            @endif


                            {{-- TANGGAL --}}

                            <div
                                class="absolute bottom-3 left-3
                                       rounded-xl bg-white
                                       px-4 py-2 shadow-md"
                            >

                                <p
                                    class="text-xl font-bold
                                           text-green-700"
                                >

                                    {{ $item->tanggal->format('d') }}

                                </p>

                                <p
                                    class="text-xs font-semibold
                                           uppercase text-gray-600"
                                >

                                    {{ $item->tanggal
                                        ->locale('id')
                                        ->translatedFormat('M Y') }}

                                </p>

                            </div>

                        </div>


                        {{-- INFORMASI --}}

                        <div class="flex flex-1 flex-col p-5">

                            <div
                                class="mb-3 flex items-center
                                       gap-2 text-xs font-semibold
                                       text-green-700"
                            >

                                <i class="fa-solid fa-house"></i>

                                Dukuh
                                {{ $item->dukuh->nama_dukuh ?? '-' }}

                            </div>


                            <h3
                                class="mb-3 text-lg font-bold
                                       leading-snug text-gray-900"
                            >

                                {{ $item->judul }}

                            </h3>


                            <p
                                class="mb-5 text-sm
                                       leading-relaxed text-gray-500"
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    $item->deskripsi,
                                    110
                                ) }}

                            </p>


                            <div
                                class="mt-auto space-y-3
                                       border-t border-gray-100
                                       pt-4"
                            >

                                {{-- WAKTU --}}

                                <div
                                    class="flex items-center gap-3
                                           text-sm text-gray-600"
                                >

                                    <i
                                        class="fa-regular fa-clock
                                               w-4 text-blue-600"
                                    ></i>

                                    {{ substr($item->waktu_mulai, 11, 5) }}

                                    -

                                    {{ substr($item->waktu_selesai, 11, 5) }}

                                    WIB

                                </div>


                                {{-- LOKASI --}}

                                <div
                                    class="flex items-start gap-3
                                           text-sm text-gray-600"
                                >

                                    <i
                                        class="fa-solid fa-location-dot
                                               mt-1 w-4 text-red-600"
                                    ></i>

                                    <span>

                                        {{ $item->lokasi }}

                                    </span>

                                </div>


                                {{-- DETAIL --}}

                                <a
                                    href="{{ route('agenda.show', $item->id) }}"
                                    class="mt-4 inline-flex
                                           w-full items-center
                                           justify-center gap-2
                                           rounded-xl bg-green-600
                                           px-4 py-3
                                           text-sm font-semibold
                                           text-white transition
                                           hover:bg-green-700"
                                >

                                    Lihat Detail

                                    <i
                                        class="fa-solid fa-arrow-right"
                                    ></i>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>


{{-- ================================================= --}}
{{-- 5 KEGIATAN TERBARU --}}
{{-- ================================================= --}}

<section class="bg-gray-50 py-14 sm:py-16">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}

        <div
            class="mb-8 flex flex-col gap-4
                   sm:flex-row sm:items-end
                   sm:justify-between"
        >

            <div>

                <div
                    class="mb-3 inline-flex items-center gap-2
                           rounded-full bg-orange-100
                           px-3 py-1 text-xs
                           font-semibold text-orange-700"
                >

                    <i class="fa-solid fa-people-group"></i>

                    Dokumentasi Kegiatan

                </div>

                <h2
                    class="text-2xl font-bold
                           text-gray-900 sm:text-3xl"
                >

                    5 Kegiatan Terbaru

                </h2>

                <p class="mt-2 text-sm text-gray-500">

                    Informasi kegiatan terbaru di lingkungan
                    Kalurahan Pandowoharjo.

                </p>

            </div>


            <a
                href="{{ route('kegiatan.index') }}"
                class="inline-flex items-center gap-2
                       text-sm font-semibold text-green-700
                       transition hover:text-green-900"
            >

                Semua Kegiatan

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        {{-- DATA KEGIATAN --}}

        @if ($kegiatan->isEmpty())

            <div
                class="rounded-2xl border
                       border-dashed border-gray-300
                       bg-white px-6 py-14 text-center"
            >

                <i
                    class="fa-solid fa-people-group
                           mb-4 text-5xl text-gray-300"
                ></i>

                <h3 class="font-semibold text-gray-700">

                    Belum Ada Kegiatan

                </h3>

                <p class="mt-2 text-sm text-gray-500">

                    Belum terdapat dokumentasi kegiatan
                    yang dapat ditampilkan.

                </p>

            </div>

        @else

            <div
                class="grid gap-6
                       sm:grid-cols-2 lg:grid-cols-3"
            >

                @foreach ($kegiatan as $item)

                    <article
                        class="group flex h-full flex-col
                               overflow-hidden rounded-2xl
                               border border-gray-200
                               bg-white shadow-sm
                               transition duration-300
                               hover:-translate-y-1
                               hover:shadow-lg"
                    >

                        {{-- FOTO KEGIATAN --}}

                        <div
                            class="relative h-48
                                   overflow-hidden bg-orange-50"
                        >

                            @if ($item->fotos->isNotEmpty())

                                <img
                                    src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                                    alt="{{ $item->judul }}"
                                    class="h-full w-full object-cover
                                           transition duration-500
                                           group-hover:scale-105"
                                >

                            @else

                                <div
                                    class="flex h-full w-full
                                           flex-col items-center
                                           justify-center
                                           bg-gradient-to-br
                                           from-orange-100
                                           to-orange-50
                                           text-orange-600"
                                >

                                    <i
                                        class="fa-solid fa-people-group
                                               mb-3 text-5xl"
                                    ></i>

                                    <span class="text-sm font-semibold">

                                        Kegiatan Kalurahan

                                    </span>

                                </div>

                            @endif


                            {{-- TANGGAL --}}

                            <div
                                class="absolute bottom-3 left-3
                                       rounded-xl bg-white
                                       px-4 py-2 shadow-md"
                            >

                                <p
                                    class="text-xl font-bold
                                           text-orange-700"
                                >

                                    {{ $item->tanggal->format('d') }}

                                </p>

                                <p
                                    class="text-xs font-semibold
                                           uppercase text-gray-600"
                                >

                                    {{ $item->tanggal
                                        ->locale('id')
                                        ->translatedFormat('M Y') }}

                                </p>

                            </div>

                        </div>


                        {{-- INFORMASI --}}

                        <div class="flex flex-1 flex-col p-5">

                            {{-- DUKUH --}}

                            <div
                                class="mb-3 flex items-center
                                       gap-2 text-xs font-semibold
                                       text-orange-700"
                            >

                                <i class="fa-solid fa-house"></i>

                                Dukuh
                                {{ $item->dukuh->nama_dukuh ?? '-' }}

                            </div>


                            {{-- JUDUL --}}

                            <h3
                                class="mb-3 text-lg font-bold
                                       leading-snug text-gray-900"
                            >

                                {{ $item->judul }}

                            </h3>


                            {{-- DESKRIPSI --}}

                            <p
                                class="mb-5 text-sm
                                       leading-relaxed text-gray-500"
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    $item->deskripsi,
                                    110
                                ) }}

                            </p>


                            {{-- DETAIL --}}

                            <div
                                class="mt-auto space-y-3
                                       border-t border-gray-100
                                       pt-4"
                            >

                                <div
                                    class="flex items-start gap-3
                                           text-sm text-gray-600"
                                >

                                    <i
                                        class="fa-solid fa-location-dot
                                               mt-1 w-4 text-red-600"
                                    ></i>

                                    <span>

                                        {{ $item->lokasi }}

                                    </span>

                                </div>


                                <a
                                    href="{{ route('kegiatan.show', $item->id) }}"
                                    class="mt-4 inline-flex
                                           w-full items-center
                                           justify-center gap-2
                                           rounded-xl bg-green-600
                                           px-4 py-3
                                           text-sm font-semibold
                                           text-white transition
                                           hover:bg-green-700"
                                >

                                    Lihat Detail

                                    <i
                                        class="fa-solid fa-arrow-right"
                                    ></i>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection

@push('scripts')

{{-- FULLCALENDAR --}}
@push('scripts')

<script
    src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.21/index.global.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.21/locales-all.global.min.js">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarElement =
        document.getElementById('homeCalendar');

    if (!calendarElement) {
        return;
    }


    const calendar =
        new FullCalendar.Calendar(
            calendarElement,
            {
                initialView: 'dayGridMonth',

                locale: 'id',

                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },

                buttonText: {
                    prev: '<',
                    next: '>'
                },

                height: 'auto',

                contentHeight: 'auto',

                fixedWeekCount: false,

                displayEventTime: false,

                dayMaxEvents: 2,

                events: {
                    url: '{{ route('calendar.events') }}',
                    method: 'GET',
                    failure: function () {
                        console.error('Gagal mengambil data kalender.');
                    }
                },

                editable: false,

                selectable: false,

                eventClick: function (info) {

                    if (info.event.url) {

                        info.jsEvent.preventDefault();

                        window.location.href =
                            info.event.url;
                    }
                },

                eventDidMount: function (info) {

                    const type =
                        info.event.extendedProps.type ?? '';

                    const lokasi =
                        info.event.extendedProps.lokasi ?? '-';

                    const dukuh =
                        info.event.extendedProps.dukuh ?? '-';

                    info.el.setAttribute(
                        'title',
                        type.charAt(0).toUpperCase() +
                        type.slice(1) +
                        ': ' +
                        info.event.title +
                        '\nLokasi: ' +
                        lokasi +
                        '\nDukuh: ' +
                        dukuh +
                        '\nTipe: ' +
                        type
                    );
                }
            }
        );

    calendar.render();

}); 
</script>

@endpush

@endpush