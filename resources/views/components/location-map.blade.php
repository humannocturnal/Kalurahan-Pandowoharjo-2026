@props([
    'latitude',
    'longitude',
    'height' => '380px',
    'zoom' => 17,
])

@php
    $mapId = 'location-map-' . uniqid();

    $hasCoordinate =
        $latitude !== null &&
        $latitude !== '' &&
        $longitude !== null &&
        $longitude !== '';
@endphp


@if ($hasCoordinate)

    <div>

        {{-- MAP --}}
        <div
            id="{{ $mapId }}"
            class="relative z-0 w-full
                   overflow-hidden rounded-2xl
                   border border-gray-200"
            style="height: {{ $height }};"
        ></div>


        {{-- KOORDINAT --}}
        <div
            class="mt-3 flex flex-wrap gap-x-6 gap-y-2
                   rounded-xl bg-gray-50
                   px-4 py-3 text-sm text-gray-600"
        >

            <span>
                <i class="fa-solid fa-location-crosshairs
                          mr-1 text-green-600"></i>

                <strong>Latitude:</strong>
                {{ $latitude }}
            </span>

            <span>
                <strong>Longitude:</strong>
                {{ $longitude }}
            </span>

        </div>

    </div>


    @push('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const mapElement =
                    document.getElementById(@json($mapId));

                if (!mapElement) {
                    return;
                }


                const latitude =
                    {{ (float) $latitude }};

                const longitude =
                    {{ (float) $longitude }};


                /*
                |--------------------------------------------------------------------------
                | MAP
                |--------------------------------------------------------------------------
                */

                const map = L.map(
                    mapElement,
                    {
                        scrollWheelZoom: false
                    }
                ).setView(
                    [
                        latitude,
                        longitude
                    ],
                    {{ $zoom }}
                );


                /*
                |--------------------------------------------------------------------------
                | OPENSTREETMAP
                |--------------------------------------------------------------------------
                */

                L.tileLayer(
                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                    {
                        maxZoom: 19,

                        attribution:
                            '&copy; ' +
                            '<a href="https://www.openstreetmap.org/copyright">' +
                            'OpenStreetMap</a> contributors'
                    }
                ).addTo(map);


                /*
                |--------------------------------------------------------------------------
                | MARKER
                |--------------------------------------------------------------------------
                */

                L.marker([
                    latitude,
                    longitude
                ])
                .addTo(map)
                .bindPopup('Lokasi')
                .openPopup();


                /*
                |--------------------------------------------------------------------------
                | PERBAIKI UKURAN MAP
                |--------------------------------------------------------------------------
                */

                setTimeout(function () {

                    map.invalidateSize();

                }, 150);

            });
        </script>

    @endpush


@else

    {{-- JIKA BELUM ADA KOORDINAT --}}

    <div
        class="rounded-2xl border border-dashed
               border-gray-300 bg-gray-50
               px-6 py-12 text-center"
    >

        <div
            class="mx-auto mb-4 flex h-14 w-14
                   items-center justify-center
                   rounded-full bg-gray-100
                   text-2xl text-gray-400"
        >
            <i class="fa-solid fa-map-location-dot"></i>
        </div>

        <h4 class="font-semibold text-gray-800">
            Lokasi Belum Tersedia
        </h4>

        <p class="mt-2 text-sm text-gray-500">
            Koordinat lokasi belum ditentukan.
        </p>

    </div>

@endif