{{-- ========================================== --}}
{{-- MODAL PERINGATAN --}}
{{-- ========================================== --}}

<div
    id="unsavedModal"
    class="fixed inset-0 z-[100] hidden
           items-center justify-center bg-black/60 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="unsavedModalTitle"
    aria-describedby="unsavedModalDescription"
>

    <div class="w-full max-w-md rounded-2xl bg-white
                p-6 shadow-2xl">

        {{-- ICON --}}
        <div class="mb-5 flex h-16 w-16
                    items-center justify-center
                    rounded-full bg-yellow-100
                    text-3xl text-yellow-600">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>

        {{-- JUDUL --}}
        <h2
            id="unsavedModalTitle"
            class="text-xl font-bold text-gray-900"
        >
            Peringatan!
        </h2>

        {{-- PESAN --}}
        <p
            id="unsavedModalDescription"
            class="mt-3 leading-relaxed text-gray-600"
        >
            Apakah Anda yakin ingin meninggalkan halaman
            ini dalam kondisi belum disimpan?
        </p>

        <p class="mt-2 text-sm text-red-600">
            Perubahan yang belum disimpan akan hilang.
        </p>

        {{-- TOMBOL --}}
        <div class="mt-7 flex flex-col-reverse
                    gap-3 sm:flex-row sm:justify-end">

            <button
                type="button"
                id="stayButton"
                class="rounded-xl border border-gray-300
                       px-5 py-3 text-sm font-semibold
                       text-gray-700 hover:bg-gray-100"
            >
                Tidak, Tetap di Sini
            </button>

            <button
                type="button"
                id="leaveButton"
                class="rounded-xl bg-red-600 px-5 py-3
                       text-sm font-semibold text-white
                       hover:bg-red-700"
            >
                Ya, Tinggalkan
            </button>

        </div>

    </div>

</div>


{{-- ========================================== --}}
{{-- JAVASCRIPT --}}
{{-- ========================================== --}}

@push('scripts')

<script>
(function () {

    function initializeUnsavedWarning() {

        const form = document.querySelector('[data-unsaved-form]');
        const modal = document.getElementById('unsavedModal');
        const stayButton = document.getElementById('stayButton');
        const leaveButton = document.getElementById('leaveButton');

        if (!form || !modal || !stayButton || !leaveButton) {
            console.warn('Unsaved Warning: Komponen belum lengkap.');
            return;
        }

        // Hindari pemasangan event berulang.
        if (form.dataset.warningInitialized === 'true') {
            return;
        }

        form.dataset.warningInitialized = 'true';

        let isDirty = false;
        let allowLeave = false;
        let guardActive = false;

        let pendingAction = null;
        let pendingUrl = null;
        let previousFocus = null;


        // =====================================
        // HISTORY GUARD
        // =====================================

        function activateHistoryGuard() {

            if (guardActive) {
                return;
            }

            history.pushState(
                { unsavedFormGuard: true },
                '',
                window.location.href
            );

            guardActive = true;
        }


        // =====================================
        // DETEKSI PERUBAHAN
        // =====================================

        function markAsDirty() {

            if (allowLeave) {
                return;
            }

            isDirty = true;

            // Tambahkan history pelindung
            // hanya setelah formulir berubah.
            activateHistoryGuard();
        }

        form.addEventListener('input', markAsDirty);

        form.addEventListener('change', markAsDirty);

        // Event dari komponen preview gambar.
        form.addEventListener(
            'upload-files-changed',
            markAsDirty
        );


        // =====================================
        // MODAL
        // =====================================

        function showModal(action, url = null) {

            pendingAction = action;
            pendingUrl = url;
            previousFocus = document.activeElement;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';

            stayButton.focus();
        }


        function hideModal() {

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.style.overflow = '';

            if (
                previousFocus &&
                previousFocus.isConnected
            ) {
                previousFocus.focus();
            }
        }


        // =====================================
        // BACK BROWSER
        // =====================================

        window.addEventListener('popstate', function () {

            if (allowLeave) {
                return;
            }

            if (!isDirty) {
                return;
            }

            // Firefox sudah memundurkan history
            // ketika event popstate diterima.
            //
            // Segera buat ulang entry pelindung
            // agar halaman tidak ditinggalkan
            // sebelum pengguna memilih.

            history.pushState(
                { unsavedFormGuard: true },
                '',
                window.location.href
            );

            guardActive = true;

            if (modal.classList.contains('hidden')) {
                showModal('history');
            }

        });


        // =====================================
        // TOMBOL KEMBALI / BATAL
        // =====================================

        document.querySelectorAll('[data-guard-back]')
            .forEach(function (link) {

                link.addEventListener('click', function (event) {

                    if (allowLeave || !isDirty) {
                        return;
                    }

                    event.preventDefault();

                    showModal('link', link.href);

                });

            });


        // =====================================
        // PILIH TIDAK
        // =====================================

        stayButton.addEventListener('click', function () {

            pendingAction = null;
            pendingUrl = null;

            hideModal();

            // History guard tetap aktif.
            // Seluruh data formulir dipertahankan.

        });


        // =====================================
        // PILIH YA
        // =====================================

        leaveButton.addEventListener('click', function () {

            const action = pendingAction;
            const url = pendingUrl;

            allowLeave = true;
            isDirty = false;

            pendingAction = null;
            pendingUrl = null;

            hideModal();

            if (action === 'history') {

                // Dari posisi history guard,
                // lewati entry pelindung dan
                // kembali ke halaman sebelumnya.

                if (history.length > 2) {
                    history.go(-2);
                } else {
                    window.location.assign(
                        form.dataset.fallbackUrl || '/admin'
                    );
                }

                return;
            }

            if (action === 'link' && url) {

                window.location.assign(url);

            }

        });


        // =====================================
        // SUBMIT FORM
        // =====================================

        form.addEventListener('submit', function () {

            // Form yang valid boleh dikirim
            // tanpa peringatan tambahan.

            allowLeave = true;
            isDirty = false;

        });


        // =====================================
        // REFRESH / TUTUP TAB
        // =====================================

        window.addEventListener('beforeunload', function (event) {

            if (!isDirty || allowLeave) {
                return;
            }

            event.preventDefault();

            event.returnValue = true;

        });


        // =====================================
        // ESCAPE
        // =====================================

        document.addEventListener('keydown', function (event) {

            if (
                event.key === 'Escape' &&
                !modal.classList.contains('hidden')
            ) {

                event.preventDefault();

                stayButton.click();

            }

        });


        console.info('Unsaved Warning berhasil diaktifkan.');

    }


    // Kompatibel dengan script yang dimuat
    // sebelum ataupun setelah DOMContentLoaded.

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initializeUnsavedWarning
        );

    } else {

        initializeUnsavedWarning();

    }

})();
</script>

@endpush