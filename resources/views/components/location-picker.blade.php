@props([
    'latitudeId' => 'latitude',
    'longitudeId' => 'longitude',
    'latitude' => null,
    'longitude' => null,
])

@php
    $mapId = 'map-' . uniqid();

    // Titik default sekitar wilayah Sleman / Yogyakarta.
    // Hanya digunakan ketika data belum mempunyai koordinat.
    $defaultLatitude = -7.7167;
    $defaultLongitude = 110.3556;

    $initialLatitude = $latitude ?: $defaultLatitude;
    $initialLongitude = $longitude ?: $defaultLongitude;

    $hasCoordinate =
        $latitude !== null &&
        $latitude !== '' &&
        $longitude !== null &&
        $longitude !== '';
@endphp


<div class="location-picker" style="z-index: 0;">

    <div class="mb-3">

        <h3 class="text-sm font-semibold text-gray-700">
            Pilih Lokasi pada Peta
        </h3>

        <p class="mt-1 text-xs text-gray-500">
            Klik pada peta atau geser marker untuk menentukan lokasi.
            Latitude dan longitude akan terisi otomatis.
        </p>

    </div>


    {{-- MAP --}}

    <div
        id="{{ $mapId }}"
        class="relative z-0 h-[400px] w-full
            overflow-hidden rounded-2xl
            border border-gray-300"
    ></div>

    {{-- INFO KOORDINAT --}}

    <div
        class="mt-3 flex flex-wrap items-center
               gap-x-6 gap-y-2 rounded-xl
               bg-gray-50 px-4 py-3
               text-sm text-gray-600"
    >

        <span>
            <strong>Latitude:</strong>

            <span id="{{ $mapId }}-latitude">
                {{ $hasCoordinate ? $latitude : '-' }}
            </span>
        </span>

        <span>
            <strong>Longitude:</strong>

            <span id="{{ $mapId }}-longitude">
                {{ $hasCoordinate ? $longitude : '-' }}
            </span>
        </span>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const latitudeInput =
        document.getElementById(@json($latitudeId));

    const longitudeInput =
        document.getElementById(@json($longitudeId));

    const latitudeText =
        document.getElementById(@json($mapId . '-latitude'));

    const longitudeText =
        document.getElementById(@json($mapId . '-longitude'));


    if (!latitudeInput || !longitudeInput) {

        console.warn(
            'Location Picker: input latitude / longitude tidak ditemukan.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | POSISI AWAL
    |--------------------------------------------------------------------------
    */

    const defaultLatitude = {{ $defaultLatitude }};

    const defaultLongitude = {{ $defaultLongitude }};


    let initialLatitude =
        parseFloat(latitudeInput.value) || defaultLatitude;

    let initialLongitude =
        parseFloat(longitudeInput.value) || defaultLongitude;


    /*
    |--------------------------------------------------------------------------
    | MAP
    |--------------------------------------------------------------------------
    */

    const map = L.map(@json($mapId)).setView(
        [
            initialLatitude,
            initialLongitude
        ],
        {{ $hasCoordinate ? 17 : 13 }}
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
                '&copy; <a href="https://www.openstreetmap.org/copyright">' +
                'OpenStreetMap</a> contributors'
        }
    ).addTo(map);


    /*
    |--------------------------------------------------------------------------
    | MARKER
    |--------------------------------------------------------------------------
    */

    let marker = null;


    function createOrMoveMarker(latitude, longitude) {

        if (marker) {

            marker.setLatLng([
                latitude,
                longitude
            ]);

            return;
        }


        marker = L.marker(
            [
                latitude,
                longitude
            ],
            {
                draggable: true
            }
        ).addTo(map);


        /*
        |--------------------------------------------------------------------------
        | MARKER DIGESER
        |--------------------------------------------------------------------------
        */

        marker.on('dragend', function () {

            const position = marker.getLatLng();

            updateCoordinates(
                position.lat,
                position.lng
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE INPUT
    |--------------------------------------------------------------------------
    */

    function updateCoordinates(latitude, longitude) {

        const lat = Number(latitude).toFixed(7);

        const lng = Number(longitude).toFixed(7);


        latitudeInput.value = lat;

        longitudeInput.value = lng;


        latitudeText.textContent = lat;

        longitudeText.textContent = lng;


        createOrMoveMarker(
            parseFloat(lat),
            parseFloat(lng)
        );


        /*
        |--------------------------------------------------------------------------
        | MEMICU EVENT CHANGE
        |--------------------------------------------------------------------------
        |
        | Berguna untuk unsaved-warning yang sebelumnya kita buat.
        |
        */

        latitudeInput.dispatchEvent(
            new Event('change', {
                bubbles: true
            })
        );

        longitudeInput.dispatchEvent(
            new Event('change', {
                bubbles: true
            })
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MARKER AWAL
    |--------------------------------------------------------------------------
    */

    @if ($hasCoordinate)

        createOrMoveMarker(
            initialLatitude,
            initialLongitude
        );

    @endif


    /*
    |--------------------------------------------------------------------------
    | KLIK PETA
    |--------------------------------------------------------------------------
    */

    map.on('click', function (event) {

        updateCoordinates(
            event.latlng.lat,
            event.latlng.lng
        );

    });


    /*
    |--------------------------------------------------------------------------
    | INPUT LATITUDE MANUAL
    |--------------------------------------------------------------------------
    */

    function updateMapFromInputs() {

        const latitude =
            parseFloat(latitudeInput.value);

        const longitude =
            parseFloat(longitudeInput.value);


        if (
            !Number.isFinite(latitude) ||
            !Number.isFinite(longitude)
        ) {

            return;

        }


        if (
            latitude < -90 ||
            latitude > 90 ||
            longitude < -180 ||
            longitude > 180
        ) {

            return;

        }


        createOrMoveMarker(
            latitude,
            longitude
        );


        map.setView(
            [
                latitude,
                longitude
            ],
            17
        );


        latitudeText.textContent =
            latitude.toFixed(7);

        longitudeText.textContent =
            longitude.toFixed(7);

    }


    latitudeInput.addEventListener(
        'change',
        updateMapFromInputs
    );


    longitudeInput.addEventListener(
        'change',
        updateMapFromInputs
    );


    /*
    |--------------------------------------------------------------------------
    | PERBAIKAN UKURAN LEAFLET
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        map.invalidateSize();

    }, 150);

});

</script>

@endpush