<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Admin - Kalurahan Pandowoharjo')
    </title>

    {{-- TAILWIND CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FONT AWESOME --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
    {{-- LEAFLET CSS --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <style>
        /* Turunkan seluruh layer Leaflet */
        .leaflet-container,
        .leaflet-pane,
        .leaflet-top,
        .leaflet-bottom,
        .leaflet-control {
            z-index: 0 !important;
        }

        .leaflet-pane {
            z-index: 0 !important;
        }

        .leaflet-map-pane {
            z-index: 0 !important;
        }

        .leaflet-tile-pane {
            z-index: 0 !important;
        }

        .leaflet-overlay-pane {
            z-index: 0 !important;
        }

        .leaflet-shadow-pane {
            z-index: 0 !important;
        }

        .leaflet-marker-pane {
            z-index: 0 !important;
        }

        .leaflet-tooltip-pane,
        .leaflet-popup-pane {
            z-index: 1 !important;
        }
    </style>

    {{-- LEAFLET JS --}}
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
    </script>
    @stack('scripts')

    @stack('styles')

</head>

<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen flex-col">


    {{-- ========================================== --}}
    {{-- 1. HEADER --}}
    {{-- ========================================== --}}

    <header
        class="sticky top-0 z-40
               bg-green-700 text-white shadow-md"
    >

        <div class="flex min-h-20 items-center justify-between
                    gap-4 px-4 py-3 sm:px-6">


            {{-- KIRI: MENU MOBILE DAN IDENTITAS --}}

            <div class="flex min-w-0 items-center gap-3 sm:gap-4">


                {{-- HAMBURGER MOBILE --}}

                <button
                    type="button"
                    id="sidebarButton"
                    aria-label="Buka menu sidebar"
                    aria-expanded="false"
                    aria-controls="adminSidebar"
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl bg-white/10
                           transition hover:bg-white/20
                           lg:hidden"
                >

                    <i class="fa-solid fa-bars text-lg"></i>

                </button>


                {{-- LOGO --}}

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="shrink-0"
                >

                    <img
                        src="{{ asset('images/logicon.png') }}"
                        alt="Logo Kalurahan Pandowoharjo"
                        class="h-11 w-11 object-contain
                               sm:h-14 sm:w-14"
                    >

                </a>


                {{-- JUDUL DAN SUBJUDUL --}}

                <div class="min-w-0">

                    <h1
                        class="text-sm font-bold leading-tight
                               sm:text-xl lg:text-2xl"
                    >

                        Kalurahan Pandowoharjo

                    </h1>

                    <p
                        class="mt-1 text-xs text-green-100
                               sm:text-sm"
                    >

                        Manajemen Agenda dan Kegiatan

                    </p>

                </div>

            </div>



            {{-- KANAN: USER DAN LOGOUT --}}

            <div class="flex shrink-0 items-center gap-3">


                {{-- NAMA ADMIN --}}

                <div
                    class="hidden text-right md:block"
                >

                    <p class="text-sm font-semibold">

                        {{ auth()->user()->name }}

                    </p>

                    <p class="text-xs text-green-100">

                        Administrator

                    </p>

                </div>



                {{-- AVATAR --}}

                <div
                    class="hidden h-10 w-10
                           items-center justify-center
                           rounded-full bg-white/20
                           text-white md:flex"
                >

                    <i class="fa-solid fa-user"></i>

                </div>



                {{-- LOGOUT --}}

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center
                               justify-center gap-2
                               rounded-xl bg-white/10
                               px-3 py-2.5
                               text-sm font-semibold
                               transition hover:bg-white/20
                               sm:px-4"
                    >

                        <i class="fa-solid fa-right-from-bracket"></i>

                        <span class="hidden sm:inline">

                            Logout

                        </span>

                    </button>

                </form>


            </div>

        </div>

    </header>



    {{-- ========================================== --}}
    {{-- AREA SIDEBAR DAN CONTENT --}}
    {{-- ========================================== --}}

    <div class="relative flex w-full flex-1">


        {{-- ====================================== --}}
        {{-- OVERLAY MOBILE --}}
        {{-- ====================================== --}}

        <div
            id="sidebarOverlay"
            class="fixed inset-0 z-40 hidden
                   bg-black/50 lg:hidden"
            onclick="closeSidebar()"
        ></div>



        {{-- ====================================== --}}
        {{-- 2. SIDEBAR --}}
        {{-- ====================================== --}}

        <aside
            id="adminSidebar"
            class="fixed bottom-0 left-0 top-20 z-50
                   w-64 -translate-x-full
                   overflow-y-auto border-r border-gray-200
                   bg-white shadow-xl
                   transition-transform duration-300
                   lg:sticky lg:top-20 lg:z-30
                   lg:h-[calc(100vh-5rem)]
                   lg:shrink-0 lg:translate-x-0
                   lg:shadow-none"
        >


            <div class="p-5">


                {{-- JUDUL SIDEBAR --}}

                <div
                    class="mb-5 border-b border-gray-100
                           pb-5"
                >

                    <p
                        class="text-xs font-bold uppercase
                               tracking-wider text-gray-400"
                    >

                        Menu Administrator

                    </p>

                </div>



                {{-- NAVIGASI --}}

                <nav class="space-y-2">


                    {{-- DASHBOARD --}}

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3
                               rounded-xl px-4 py-3
                               text-sm font-semibold
                               transition

                               {{ request()->routeIs('admin.dashboard')
                                   ? 'bg-green-600 text-white shadow-sm'
                                   : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}"
                    >

                        <i
                            class="fa-solid fa-gauge-high
                                   w-5 text-center"
                        ></i>

                        Dashboard

                    </a>



                    {{-- MANAGE DUKUH --}}

                    <a
                        href="{{ route('admin.dukuh') }}"
                        class="flex items-center gap-3
                               rounded-xl px-4 py-3
                               text-sm font-semibold
                               transition

                               {{ request()->routeIs('admin.dukuh*')
                                   ? 'bg-green-600 text-white shadow-sm'
                                   : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}"
                    >

                        <i
                            class="fa-solid fa-house
                                   w-5 text-center"
                        ></i>

                        Manage Dukuh

                    </a>



                    {{-- MANAGE AGENDA --}}

                    <a
                        href="{{ route('admin.agenda') }}"
                        class="flex items-center gap-3
                               rounded-xl px-4 py-3
                               text-sm font-semibold
                               transition

                               {{ request()->routeIs('admin.agenda*')
                                   ? 'bg-green-600 text-white shadow-sm'
                                   : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}"
                    >

                        <i
                            class="fa-solid fa-calendar-days
                                   w-5 text-center"
                        ></i>

                        Manage Agenda

                    </a>



                    {{-- MANAGE KEGIATAN --}}

                    <a
                        href="{{ route('admin.kegiatan') }}"
                        class="flex items-center gap-3
                               rounded-xl px-4 py-3
                               text-sm font-semibold
                               transition

                               {{ request()->routeIs('admin.kegiatan*')
                                   ? 'bg-green-600 text-white shadow-sm'
                                   : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}"
                    >

                        <i
                            class="fa-solid fa-people-group
                                   w-5 text-center"
                        ></i>

                        Manage Kegiatan

                    </a>


                </nav>



                {{-- PEMBATAS --}}

                <div class="my-6 border-t border-gray-100"></div>



                {{-- WEBSITE PENGUNJUNG --}}

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-3
                           rounded-xl px-4 py-3
                           text-sm font-semibold
                           text-gray-600 transition
                           hover:bg-green-50
                           hover:text-green-700"
                >

                    <i
                        class="fa-solid fa-arrow-up-right-from-square
                               w-5 text-center"
                    ></i>

                    Lihat Website

                </a>


            </div>


        </aside>



        {{-- ====================================== --}}
        {{-- 3. KONTEN --}}
        {{-- ====================================== --}}

        <div class="flex min-w-0 flex-1 flex-col">


            <main
                class="w-full flex-1
                       px-4 py-6
                       sm:px-6 sm:py-8
                       lg:px-8"
            >

                <div class="mx-auto max-w-7xl">


                    {{-- NOTIFIKASI SUKSES --}}

                    @if (session('success'))

                        <div
                            class="mb-6 flex items-start gap-3
                                   rounded-xl border border-green-200
                                   bg-green-50 px-5 py-4
                                   text-sm text-green-700"
                        >

                            <i class="fa-solid fa-circle-check mt-0.5"></i>

                            <span>

                                {{ session('success') }}

                            </span>

                        </div>

                    @endif



                    {{-- NOTIFIKASI ERROR --}}

                    @if (session('error'))

                        <div
                            class="mb-6 flex items-start gap-3
                                   rounded-xl border border-red-200
                                   bg-red-50 px-5 py-4
                                   text-sm text-red-700"
                        >

                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>

                            <span>

                                {{ session('error') }}

                            </span>

                        </div>

                    @endif



                    {{-- KONTEN DINAMIS --}}

                    @yield('content')


                </div>

            </main>



            {{-- ================================== --}}
            {{-- 4. FOOTER --}}
            {{-- ================================== --}}

            <footer
                class="border-t border-gray-200
                       bg-white px-4 py-5
                       sm:px-6 lg:px-8"
            >

                <p
                    class="text-center text-sm
                           text-gray-500"
                >

                    &copy; 2026 Kalurahan Pandowoharjo

                </p>

            </footer>


        </div>


    </div>


</div>



{{-- ========================================== --}}
{{-- JAVASCRIPT SIDEBAR MOBILE --}}
{{-- ========================================== --}}

<script>

    const sidebarButton = document.getElementById('sidebarButton');

    const sidebar = document.getElementById('adminSidebar');

    const sidebarOverlay = document.getElementById('sidebarOverlay');


    function openSidebar() {

        sidebar.classList.remove('-translate-x-full');

        sidebarOverlay.classList.remove('hidden');

        sidebarButton.setAttribute('aria-expanded', 'true');

        document.body.style.overflow = 'hidden';

    }


    function closeSidebar() {

        sidebar.classList.add('-translate-x-full');

        sidebarOverlay.classList.add('hidden');

        sidebarButton.setAttribute('aria-expanded', 'false');

        document.body.style.overflow = '';

    }


    sidebarButton.addEventListener('click', function () {

        if (sidebar.classList.contains('-translate-x-full')) {

            openSidebar();

        } else {

            closeSidebar();

        }

    });



    // Tutup sidebar dengan tombol Escape.

    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            closeSidebar();

        }

    });



    // Tutup sidebar ketika ukuran layar kembali desktop.

    window.addEventListener('resize', function() {

        if (window.innerWidth >= 1024) {

            closeSidebar();

        }

    });

</script>


<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

@stack('scripts')

</body>
</html>