@props([
    'latitude',
    'longitude',
    'height' => '350px',
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

        <div
            id="{{ $mapId }}"
            class="w-full overflow-hidden
                   rounded-2xl border border-gray-300"
            style="height: {{ $height }};"
        ></div>

        <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2
                    rounded-xl bg-gray-50 px-4 py-3
                    text-sm text-gray-600">

            <span>
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

            const latitude = {{ (float) $latitude }};
            const longitude = {{ (float) $longitude }};

            const map = L.map(@json($mapId), {
                scrollWheelZoom: false
            }).setView(
                [latitude, longitude],
                {{ $zoom }}
            );


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


            L.marker([
                latitude,
                longitude
            ]).addTo(map);


            setTimeout(function () {
                map.invalidateSize();
            }, 150);

        });
    </script>

    @endpush

@else

    <div class="rounded-2xl border border-dashed
                border-gray-300 bg-gray-50
                px-6 py-10 text-center">

        <i class="fa-solid fa-map-location-dot
                  mb-3 text-4xl text-gray-300"></i>

        <p class="text-sm text-gray-500">
            Lokasi pada peta belum ditentukan.
        </p>

    </div>

@endif