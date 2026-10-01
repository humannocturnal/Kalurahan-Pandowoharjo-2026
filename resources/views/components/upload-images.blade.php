@props([
    'name' => 'fotos',
    'label' => 'Upload Foto',
    'maxSize' => 5
])

@php
    $inputId = 'upload-images-' . uniqid();
@endphp


<div
    class="upload-images-component"
    data-max-size="{{ $maxSize }}"
>


    {{-- LABEL --}}

    <label class="mb-3 block text-sm font-semibold text-gray-700">

        {{ $label }}

    </label>



    {{-- AREA UPLOAD --}}

    <div
        class="rounded-2xl border-2 border-dashed
               border-gray-300 bg-gray-50
               p-6 text-center transition
               hover:border-green-500 hover:bg-green-50"
    >


        {{-- ICON --}}

        <div
            class="mx-auto mb-4 flex h-16 w-16
                   items-center justify-center
                   rounded-full bg-green-100
                   text-3xl text-green-600"
        >

            <i class="fa-regular fa-images"></i>

        </div>



        <h3 class="font-semibold text-gray-800">
            Pilih Foto
        </h3>


        <p class="mt-2 text-sm text-gray-500">

            Pilih satu atau beberapa foto untuk diunggah.

        </p>



        {{-- TOMBOL PILIH GAMBAR --}}

        <label
            for="{{ $inputId }}"
            class="mt-5 inline-flex cursor-pointer
                   items-center justify-center gap-2
                   rounded-xl bg-green-600
                   px-5 py-3 text-sm font-semibold
                   text-white transition hover:bg-green-700"
        >

            <i class="fa-solid fa-cloud-arrow-up"></i>

            Pilih Gambar

        </label>



        {{-- INPUT FILE --}}

        <input
            type="file"
            id="{{ $inputId }}"
            name="{{ $name }}[]"
            multiple
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
            class="upload-images-input sr-only"
        >



        <p class="mt-4 text-xs text-gray-500">

            JPG, JPEG, PNG.
            Maksimal {{ $maxSize }} MB per foto.

        </p>


    </div>



    {{-- INFORMASI JUMLAH FOTO --}}

    <div
        class="upload-images-info mt-4 hidden
               items-center justify-between
               rounded-xl bg-green-50
               px-4 py-3"
    >


        <span
            class="upload-images-count
                   text-sm font-semibold text-green-700"
        >

            0 foto dipilih

        </span>



        <button
            type="button"
            class="upload-images-clear
                   text-sm font-semibold text-red-600
                   hover:text-red-700"
        >

            Hapus Semua

        </button>


    </div>



    {{-- ERROR JAVASCRIPT --}}

    <div
        class="upload-images-error
               mt-3 hidden rounded-xl
               border border-red-200
               bg-red-50 px-4 py-3
               text-sm text-red-600"
        role="alert"
    ></div>



    {{-- PREVIEW FOTO --}}

    <div
        class="upload-images-preview
               mt-5 grid grid-cols-2 gap-4
               sm:grid-cols-3 lg:grid-cols-4"
    ></div>



    {{-- ERROR VALIDASI LARAVEL --}}

    @error($name)

        <p class="mt-2 text-sm text-red-600">

            {{ $message }}

        </p>

    @enderror


    @foreach ($errors->get($name . '.*') as $messages)

        @foreach ($messages as $message)

            <p class="mt-2 text-sm text-red-600">

                {{ $message }}

            </p>

        @endforeach

    @endforeach


</div>



{{-- ========================================== --}}
{{-- JAVASCRIPT UPLOAD PREVIEW --}}
{{-- ========================================== --}}

@once

    @push('scripts')

        <script>

            (function () {

                function initializeUploadComponents() {

                    const components = document.querySelectorAll(
                        '.upload-images-component:not([data-initialized])'
                    );


                    components.forEach(function (component) {

                        component.dataset.initialized = 'true';


                        const input = component.querySelector(
                            '.upload-images-input'
                        );

                        const preview = component.querySelector(
                            '.upload-images-preview'
                        );

                        const info = component.querySelector(
                            '.upload-images-info'
                        );

                        const count = component.querySelector(
                            '.upload-images-count'
                        );

                        const clear = component.querySelector(
                            '.upload-images-clear'
                        );

                        const error = component.querySelector(
                            '.upload-images-error'
                        );


                        const maxSize =
                            Number(component.dataset.maxSize) * 1024 * 1024;


                        let selectedFiles = [];

                        let previewUrls = [];



                        // =====================================
                        // SINKRONISASI FILE
                        // =====================================

                       function syncInput() {

                            const transfer = new DataTransfer();

                            selectedFiles.forEach(function (file) {

                                transfer.items.add(file);

                            });

                            input.files = transfer.files;


                            // Beritahu formulir bahwa terdapat perubahan.

                            input.dispatchEvent(
                                new CustomEvent('upload-files-changed', {
                                    bubbles: true
                                })
                            );

                        }



                        // =====================================
                        // BERSIHKAN URL PREVIEW
                        // =====================================

                        function clearPreviewUrls() {

                            previewUrls.forEach(function (url) {

                                URL.revokeObjectURL(url);

                            });


                            previewUrls = [];

                        }



                        // =====================================
                        // TAMPILKAN ERROR
                        // =====================================

                        function showError(message) {

                            error.textContent = message;

                            error.classList.remove('hidden');

                        }



                        function hideError() {

                            error.textContent = '';

                            error.classList.add('hidden');

                        }



                        // =====================================
                        // TAMPILKAN PREVIEW
                        // =====================================

                        function renderPreview() {

                            clearPreviewUrls();

                            preview.replaceChildren();


                            count.textContent =
                                selectedFiles.length + ' foto dipilih';


                            info.classList.toggle(
                                'hidden',
                                selectedFiles.length === 0
                            );


                            info.classList.toggle(
                                'flex',
                                selectedFiles.length > 0
                            );



                            selectedFiles.forEach(function (file, index) {


                                const url = URL.createObjectURL(file);

                                previewUrls.push(url);



                                // CARD

                                const card = document.createElement('div');

                                card.className =
                                    'overflow-hidden rounded-xl ' +
                                    'border border-gray-200 bg-white shadow-sm';



                                // WRAPPER FOTO

                                const wrapper = document.createElement('div');

                                wrapper.className = 'relative';



                                // FOTO

                                const image = document.createElement('img');

                                image.src = url;

                                image.alt = file.name;

                                image.className =
                                    'h-36 w-full object-cover sm:h-40';



                                // TOMBOL HAPUS

                                const remove = document.createElement('button');

                                remove.type = 'button';

                                remove.className =
                                    'absolute right-2 top-2 ' +
                                    'flex h-8 w-8 items-center justify-center ' +
                                    'rounded-full bg-red-600 text-white ' +
                                    'shadow-md transition hover:bg-red-700';


                                remove.setAttribute(
                                    'aria-label',
                                    'Hapus ' + file.name
                                );


                                const removeIcon = document.createElement('i');

                                removeIcon.className = 'fa-solid fa-xmark';

                                remove.appendChild(removeIcon);



                                remove.addEventListener('click', function () {

                                    selectedFiles.splice(index, 1);

                                    syncInput();

                                    renderPreview();

                                });



                                wrapper.appendChild(image);

                                wrapper.appendChild(remove);



                                // INFORMASI FILE

                                const details = document.createElement('div');

                                details.className = 'p-3';



                                const filename = document.createElement('p');

                                filename.className =
                                    'truncate text-xs font-semibold ' +
                                    'text-gray-800';


                                filename.textContent = file.name;

                                filename.title = file.name;



                                const filesize = document.createElement('p');

                                filesize.className =
                                    'mt-1 text-xs text-gray-500';


                                filesize.textContent =
                                    (file.size / 1024 / 1024).toFixed(2) +
                                    ' MB';



                                details.appendChild(filename);

                                details.appendChild(filesize);



                                card.appendChild(wrapper);

                                card.appendChild(details);



                                preview.appendChild(card);


                            });

                        }



                        // =====================================
                        // KETIKA MEMILIH FOTO
                        // =====================================

                        input.addEventListener('change', function () {


                            hideError();


                            const incomingFiles = Array.from(input.files);


                            const allowedTypes = [
                                'image/jpeg',
                                'image/png'
                            ];


                            const invalidFiles = [];


                            incomingFiles.forEach(function (file) {


                                const extension = file.name
                                    .split('.')
                                    .pop()
                                    .toLowerCase();



                                const validExtension = [
                                    'jpg',
                                    'jpeg',
                                    'png'
                                ].includes(extension);



                                if (
                                    !allowedTypes.includes(file.type) ||
                                    !validExtension
                                ) {

                                    invalidFiles.push(
                                        file.name + ': format tidak didukung'
                                    );

                                    return;

                                }



                                if (file.size > maxSize) {

                                    invalidFiles.push(
                                        file.name + ': ukuran melebihi batas'
                                    );

                                    return;

                                }



                                selectedFiles.push(file);


                            });



                            if (invalidFiles.length > 0) {

                                showError(invalidFiles.join('; '));

                            }



                            syncInput();

                            renderPreview();


                        });



                        // =====================================
                        // HAPUS SEMUA
                        // =====================================

                        clear.addEventListener('click', function () {


                            selectedFiles = [];


                            syncInput();

                            renderPreview();

                            hideError();


                        });



                    });

                }



                // JALANKAN SETELAH DOM SIAP

                if (document.readyState === 'loading') {

                    document.addEventListener(
                        'DOMContentLoaded',
                        initializeUploadComponents
                    );

                } else {

                    initializeUploadComponents();

                }

            })();

        </script>

    @endpush

@endonce