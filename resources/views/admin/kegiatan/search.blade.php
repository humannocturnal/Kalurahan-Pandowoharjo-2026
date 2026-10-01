<div class="mb-6 rounded-2xl border border-gray-200
            bg-white p-5 shadow-sm">

    <form
        action="{{ route('admin.kegiatan') }}"
        method="GET"
        class="flex flex-col gap-3 sm:flex-row"
    >

        <div class="relative flex-1">

            <i class="fa-solid fa-magnifying-glass
                      absolute left-4 top-1/2
                      -translate-y-1/2 text-gray-400"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul, lokasi, atau nama dukuh..."
                class="w-full rounded-xl border border-gray-300
                       py-3 pl-11 pr-4 outline-none
                       focus:border-green-500 focus:ring-2
                       focus:ring-green-100"
            >

        </div>

        <button
            type="submit"
            class="rounded-xl bg-green-600 px-6 py-3
                   font-semibold text-white hover:bg-green-700"
        >
            <i class="fa-solid fa-magnifying-glass mr-2"></i>
            Cari
        </button>

        @if (request('search'))

            <a
                href="{{ route('admin.kegiatan') }}"
                class="rounded-xl bg-gray-200 px-6 py-3
                       text-center font-semibold text-gray-700
                       hover:bg-gray-300"
            >
                Reset
            </a>

        @endif

    </form>

</div>