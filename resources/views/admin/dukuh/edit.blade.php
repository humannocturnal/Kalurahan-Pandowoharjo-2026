<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Dukuh</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <main class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">

        <a
            href="{{ route('admin.dukuh') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 hover:text-green-700"
        >
            ← Kembali ke Daftar Dukuh
        </a>

        <div class="mt-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <h1 class="text-2xl font-bold text-gray-900">
                Edit Dukuh
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Ubah data dukuh yang dipilih.
            </p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.dukuh.update', $dukuh->id) }}"
                class="mt-6 space-y-5"
            >
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Dukuh
                    </label>

                    <input
                        type="text"
                        name="nama_dukuh"
                        value="{{ old('nama_dukuh', $dukuh->nama_dukuh) }}"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Kepala Dukuh
                    </label>

                    <input
                        type="text"
                        name="nama_kepala_dukuh"
                        value="{{ old('nama_kepala_dukuh', $dukuh->nama_kepala_dukuh) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="4"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >{{ old('alamat', $dukuh->alamat) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button
                        type="submit"
                        class="rounded-xl bg-green-600 px-5 py-3 font-semibold text-white transition hover:bg-green-700"
                    >
                        Simpan Perubahan
                    </button>

                    <a
                        href="{{ route('admin.dukuh') }}"
                        class="rounded-xl bg-gray-200 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-300"
                    >
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </main>

</body>
</html>