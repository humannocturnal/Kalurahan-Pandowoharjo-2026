<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

    <form
        action="{{ route('admin.dukuh') }}"
        method="GET"
        class="flex flex-col gap-3 sm:flex-row"
    >

        <div class="relative flex-1">

            <i
                class="fa-solid fa-magnifying-glass
                       absolute left-4 top-1/2
                       -translate-y-1/2
                       text-gray-400"
            ></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama dukuh atau kepala dukuh..."
                class="w-full rounded-xl
                       border border-gray-300
                       py-3 pl-11 pr-4
                       outline-none transition
                       focus:border-green-500
                       focus:ring-2
                       focus:ring-green-100"
            >

        </div>

        <button
            type="submit"
            class="inline-flex items-center
                   justify-center gap-2
                   rounded-xl bg-green-600
                   px-5 py-3
                   font-semibold text-white
                   transition hover:bg-green-700"
        >
            <i class="fa-solid fa-magnifying-glass"></i>
            Cari
        </button>

        @if (request('search'))

            <a
                href="{{ route('admin.dukuh') }}"
                class="inline-flex items-center
                       justify-center gap-2
                       rounded-xl bg-gray-200
                       px-5 py-3
                       font-semibold text-gray-700
                       transition hover:bg-gray-300"
            >
                <i class="fa-solid fa-xmark"></i>
                Reset
            </a>

        @endif

    </form>

</div>