<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Kalurahan Pandowoharjo')
    </title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- LEAFLET CSS --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <style>
        /*
        |--------------------------------------------------------------------------
        | LEAFLET Z-INDEX
        |--------------------------------------------------------------------------
        | Supaya peta tidak menutupi header, navbar, modal, dan elemen lainnya.
        */

        .leaflet-container,
        .leaflet-pane,
        .leaflet-top,
        .leaflet-bottom,
        .leaflet-control {
            z-index: 0 !important;
        }

        .leaflet-map-pane,
        .leaflet-tile-pane,
        .leaflet-overlay-pane,
        .leaflet-shadow-pane,
        .leaflet-marker-pane {
            z-index: 0 !important;
        }

        .leaflet-tooltip-pane,
        .leaflet-popup-pane {
            z-index: 1 !important;
        }
    </style>
    @stack('styles')

</head>

@php
    $isHome = request()->routeIs('home');
@endphp

<body
    class="{{ $isHome
        ? 'bg-white'
        : 'bg-cover bg-center bg-fixed bg-no-repeat'
    }}"
    class="min-h-screen flex flex-col bg-gray-50 text-gray-800"
    @if (!$isHome)
        style="
            background-image:
                linear-gradient(
                    rgba(215, 211, 211, 0.8),
                    rgba(255, 255, 255, 0.80)
                ),
                url('{{ asset('images/background/pengunjung-bg.png') }}');
        "
    @endif
>

    {{-- ============================================== --}}
    {{-- HEADER --}}
    {{-- ============================================== --}}

    <header class="bg-green-700 text-white shadow-md">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- IDENTITAS DAN LOGO --}}

            {{-- IDENTITAS, LOGO, DAN LOGIN --}}

            <div class="flex items-center justify-between gap-4 py-5">

                {{-- LOGO DAN JUDUL --}}
                <div class="flex min-w-0 items-center gap-3 sm:gap-4">

                    {{-- LOGO --}}
                    <a href="{{ route('home') }}" class="shrink-0">

                        <img
                            src="{{ asset('images/logicon.png') }}"
                            alt="Logo Kalurahan Pandowoharjo"
                            class="h-12 w-12 object-contain
                                sm:h-20 sm:w-20"
                        >

                    </a>

                    {{-- JUDUL --}}
                    <div class="min-w-0">

                        <h1 class="text-base font-bold leading-tight
                                sm:text-2xl lg:text-3xl">

                            Kalurahan Pandowoharjo

                        </h1>

                        <p class="mt-1 text-xs text-green-100
                                sm:text-base">

                            Manajemen Agenda dan Kegiatan

                        </p>

                    </div>

                </div>


                {{-- LOGIN ADMIN --}}
                <div class="shrink-0">

                    @auth

                        {{-- JIKA SUDAH LOGIN --}}
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center justify-center
                                gap-2 rounded-xl bg-white
                                px-3 py-2 text-sm font-semibold
                                text-green-700 shadow-sm
                                transition hover:bg-green-50
                                sm:px-5 sm:py-3"
                        >

                            <i class="fa-solid fa-gauge-high"></i>

                            <span class="hidden sm:inline">
                                Dashboard
                            </span>

                        </a>

                    @else

                        {{-- JIKA BELUM LOGIN --}}
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center
                                gap-2 rounded-xl bg-white
                                px-3 py-2 text-sm font-semibold
                                text-green-700 shadow-sm
                                transition hover:bg-green-50
                                sm:px-5 sm:py-3"
                        >

                            <i class="fa-solid fa-right-to-bracket"></i>

                            <span class="hidden sm:inline">
                                Login Admin
                            </span>

                        </a>

                    @endauth

                </div>

            </div>
        </div>

    </header>


    {{-- ============================================== --}}
    {{-- NAVIGASI --}}
    {{-- ============================================== --}}

    <nav class="bg-green-800 text-white shadow-sm">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between">

                {{-- MENU DESKTOP --}}
                <div class="hidden md:flex items-center gap-1">

                    <a
                        href="{{ route('home') }}"
                        class="px-5 py-4 text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('home')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >
                        <i class="fa-solid fa-house mr-2"></i>
                        Home
                    </a>


                    <a
                        href="{{ route('agenda.index') }}"
                        class="px-5 py-4 text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('agenda.*')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >
                        <i class="fa-solid fa-calendar-days mr-2"></i>
                        Agenda
                    </a>


                    <a
                        href="{{ route('kegiatan.index') }}"
                        class="px-5 py-4 text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('kegiatan.*')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >
                        <i class="fa-solid fa-people-group mr-2"></i>
                        Kegiatan
                    </a>

                </div>


                {{-- MENU MOBILE --}}
                <div class="flex md:hidden items-center
                            justify-between w-full py-3">

                    <span class="text-sm font-semibold">
                        Menu Navigasi
                    </span>

                    <button
                        type="button"
                        id="menuButton"
                        aria-label="Buka menu navigasi"
                        aria-expanded="false"
                        aria-controls="mobileMenu"
                        class="flex items-center justify-center
                               w-10 h-10 rounded-lg
                               bg-green-700 hover:bg-green-600
                               transition"
                    >

                        <i id="menuIcon"
                           class="fa-solid fa-bars text-xl"></i>

                    </button>

                </div>

            </div>


            {{-- DROPDOWN MOBILE --}}

            <div
                id="mobileMenu"
                class="hidden md:hidden pb-4"
            >

                <div class="flex flex-col gap-1">

                    <a
                        href="{{ route('home') }}"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-lg
                               text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('home')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >

                        <i class="fa-solid fa-house w-5"></i>

                        Home

                    </a>


                    <a
                        href="{{ route('agenda.index') }}"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-lg
                               text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('agenda.*')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >

                        <i class="fa-solid fa-calendar-days w-5"></i>

                        Agenda

                    </a>


                    <a
                        href="{{ route('kegiatan.index') }}"
                        class="flex items-center gap-3
                               px-4 py-3 rounded-lg
                               text-sm font-semibold
                               transition hover:bg-green-700
                               {{ request()->routeIs('kegiatan.*')
                                   ? 'bg-green-600'
                                   : '' }}"
                    >

                        <i class="fa-solid fa-people-group w-5"></i>

                        Kegiatan

                    </a>

                </div>

            </div>

        </div>

    </nav>


    {{-- ============================================== --}}
    {{-- CONTENT --}}
    {{-- ============================================== --}}

    <main class="flex-1 w-full">

        @yield('content')

    </main>


   {{-- ================================================= --}}
    {{-- FOOTER --}}
    {{-- ================================================= --}}

    <footer class="bg-green-900 text-white">

        <div
            class="mx-auto max-w-7xl
                px-4 py-12 sm:px-6 lg:px-8"
        >

            <div
                class="grid gap-10
                    md:grid-cols-2
                    lg:grid-cols-4"
            >

                {{-- ====================================== --}}
                {{-- IDENTITAS --}}
                {{-- ====================================== --}}

                <div>

                    <div class="flex items-center gap-3">

                        <img
                            src="{{ asset('images/logicon.png') }}"
                            alt="Logo Kalurahan Pandowoharjo"
                            class="h-14 w-14 object-contain"
                        >

                        <div>

                            <h3 class="font-bold">
                                Kalurahan Pandowoharjo
                            </h3>

                            <p class="mt-1 text-xs text-green-200">
                                Manajemen Agenda dan Kegiatan
                            </p>

                        </div>

                    </div>


                    <p
                        class="mt-5 text-sm leading-6
                            text-green-100"
                    >
                        Sistem informasi agenda dan kegiatan
                        Kalurahan Pandowoharjo.
                    </p>

                </div>


                {{-- ====================================== --}}
                {{-- ALAMAT --}}
                {{-- ====================================== --}}

                <div>

                    <h3
                        class="mb-4 text-sm font-bold
                            uppercase tracking-wider"
                    >
                        Alamat
                    </h3>

                    <div
                        class="flex items-start gap-3
                            text-sm leading-6
                            text-green-100"
                    >

                        <i
                            class="fa-solid fa-location-dot
                                mt-1 text-green-300"
                        ></i>

                        <p>
                            Jl. Kleben Jl. Pandowoharjo, Kleben Moncosan, Pandowoharjo, Kec. Sleman, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55512
                        </p>

                    </div>

                </div>


                {{-- ====================================== --}}
                {{-- INFORMASI --}}
                {{-- ====================================== --}}

                <div>

                    <h3
                        class="mb-4 text-sm font-bold
                            uppercase tracking-wider"
                    >
                        Informasi
                    </h3>

                    <ul class="space-y-3 text-sm">

                        <li>

                            <a
                                href="{{ url('/kebijakan-privasi') }}"
                                class="text-green-100
                                    transition hover:text-white"
                            >
                                Kebijakan Privasi
                            </a>

                        </li>

                        <li>

                            <a
                                href="{{ url('/syarat-penggunaan') }}"
                                class="text-green-100
                                    transition hover:text-white"
                            >
                                Syarat Penggunaan
                            </a>

                        </li>

                    </ul>

                </div>


                {{-- ====================================== --}}
                {{-- SOSIAL MEDIA --}}
                {{-- ====================================== --}}

                <div>

                    <h3
                        class="mb-4 text-sm font-bold
                            uppercase tracking-wider"
                    >
                        Media Sosial
                    </h3>

                    <a
                        href="https://www.instagram.com/Kalurahan_pandowoharjo/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex h-11 w-11
                            items-center justify-center
                            rounded-xl bg-white/10
                            text-xl transition
                            hover:bg-white/20"
                        aria-label="Instagram"
                    >
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                </div>

            </div>


            {{-- BOTTOM FOOTER --}}

            <div
                class="mt-10 flex flex-col gap-3
                    border-t border-white/10
                    pt-6 text-sm text-green-200
                    sm:flex-row
                    sm:items-center
                    sm:justify-between"
            >

                <p>
                    © {{ date('Y') }}
                    Kalurahan Pandowoharjo.
                    Hak cipta dilindungi.
                </p>

                <p>
                    Sistem Agenda dan Kegiatan
                </p>

            </div>

        </div>

    </footer>


    {{-- ============================================== --}}
    {{-- JAVASCRIPT MENU MOBILE --}}
    {{-- ============================================== --}}

    <script>

        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');

        menuButton.addEventListener('click', function () {

            mobileMenu.classList.toggle('hidden');

            const isOpen = !mobileMenu.classList.contains('hidden');

            menuButton.setAttribute('aria-expanded', isOpen);

            if (isOpen) {

                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');

            } else {

                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');

            }

        });

    </script>

    {{-- LEAFLET JS --}}
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const slides =
                document.querySelectorAll('[data-slide]');

            const dots =
                document.querySelectorAll('.hero-dot');

            const prevButton =
                document.getElementById('heroPrev');

            const nextButton =
                document.getElementById('heroNext');

            if (!slides.length) {
                return;
            }

            let currentSlide = 0;

            let autoSlide;


            function showSlide(index) {

                if (index < 0) {
                    index = slides.length - 1;
                }

                if (index >= slides.length) {
                    index = 0;
                }

                currentSlide = index;


                slides.forEach(function (slide, i) {

                    if (i === currentSlide) {
                        slide.classList.remove('opacity-0');
                        slide.classList.add('opacity-100');
                    } else {
                        slide.classList.remove('opacity-100');
                        slide.classList.add('opacity-0');
                    }

                });


                dots.forEach(function (dot, i) {

                    if (i === currentSlide) {
                        dot.classList.remove(
                            'w-2.5',
                            'bg-white/50'
                        );

                        dot.classList.add(
                            'w-8',
                            'bg-white'
                        );
                    } else {
                        dot.classList.remove(
                            'w-8',
                            'bg-white'
                        );

                        dot.classList.add(
                            'w-2.5',
                            'bg-white/50'
                        );
                    }

                });

            }


            function nextSlide() {

                showSlide(currentSlide + 1);

            }


            function previousSlide() {

                showSlide(currentSlide - 1);

            }


            function startAutoSlide() {

                autoSlide = setInterval(
                    nextSlide,
                    5000
                );

            }


            function resetAutoSlide() {

                clearInterval(autoSlide);

                startAutoSlide();

            }


            if (nextButton) {

                nextButton.addEventListener(
                    'click',
                    function () {

                        nextSlide();

                        resetAutoSlide();

                    }
                );

            }


            if (prevButton) {

                prevButton.addEventListener(
                    'click',
                    function () {

                        previousSlide();

                        resetAutoSlide();

                    }
                );

            }


            dots.forEach(function (dot) {

                dot.addEventListener(
                    'click',
                    function () {

                        const index =
                            parseInt(
                                this.dataset.dot
                            );

                        showSlide(index);

                        resetAutoSlide();

                    }
                );

            });


            showSlide(0);

            startAutoSlide();

        });
        </script>


    @stack('scripts')

</body>
</html>