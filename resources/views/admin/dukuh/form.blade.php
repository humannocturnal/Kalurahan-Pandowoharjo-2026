<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Dukuh</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="mx-auto max-w-3xl px-6 py-10">

    <a
        href="{{ route('admin.dukuh') }}"
        class="text-sm font-semibold text-green-600"
    >
        ← Kembali
    </a>

    <div class="mt-5 rounded-2xl bg-white p-6 shadow-sm">

        <h1 class="text-2xl font-bold">
            Tambah Dukuh
        </h1>

        <form
            method="POST"
            action="{{ route('admin.dukuh.store') }}"
            class="mt-6 space-y-5"
        >
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Nama Dukuh
                </label>

                <input
                    type="text"
                    name="nama_dukuh"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Nama Kepala Dukuh
                </label>

                <input
                    type="text"
                    name="nama_kepala_dukuh"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3"
                ></textarea>
            </div>

            <button
                type="submit"
                class="rounded-xl bg-green-600 px-5 py-3 font-semibold text-white"
            >
                Simpan
            </button>

        </form>

    </div>

</div>

</body>
</html>