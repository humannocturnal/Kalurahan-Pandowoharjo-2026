<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

</head>

<body class="min-h-screen bg-gray-100">

<div class="flex min-h-screen items-center justify-center px-4">

    <div class="w-full max-w-md">


        {{-- LOGO / TITLE --}}

        <div class="mb-7 text-center">

            <div
                class="mx-auto mb-4 flex h-16 w-16
                       items-center justify-center
                       rounded-2xl bg-green-600
                       text-2xl text-white shadow-lg"
            >
                <i class="fa-solid fa-building-columns"></i>
            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Admin Kalurahan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Sistem Agenda dan Kegiatan Kalurahan
            </p>

        </div>


        {{-- CARD LOGIN --}}

        <div
            class="rounded-3xl border border-gray-200
                   bg-white p-7 shadow-sm"
        >

            <h2 class="mb-6 text-xl font-bold text-gray-900">
                Login
            </h2>


            {{-- ERROR --}}

            @if ($errors->any())

                <div
                    class="mb-5 rounded-xl
                           border border-red-200
                           bg-red-50 p-4
                           text-sm text-red-700"
                >

                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('login.process') }}"
            >

                @csrf


                {{-- EMAIL --}}

                <div class="mb-5">

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Email
                    </label>

                    <div class="relative">

                        <i
                            class="fa-regular fa-envelope
                                   absolute left-4 top-1/2
                                   -translate-y-1/2 text-gray-400"
                        ></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="admin@kalurahan.test"
                            class="w-full rounded-xl
                                   border border-gray-300
                                   py-3 pl-11 pr-4
                                   outline-none transition
                                   focus:border-green-500
                                   focus:ring-2
                                   focus:ring-green-100"
                        >

                    </div>

                </div>


                {{-- PASSWORD --}}

                <div class="mb-5">

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Password
                    </label>

                    <div class="relative">

                        <i
                            class="fa-solid fa-lock
                                   absolute left-4 top-1/2
                                   -translate-y-1/2 text-gray-400"
                        ></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            class="w-full rounded-xl
                                   border border-gray-300
                                   py-3 pl-11 pr-4
                                   outline-none transition
                                   focus:border-green-500
                                   focus:ring-2
                                   focus:ring-green-100"
                        >

                    </div>

                </div>


                {{-- REMEMBER --}}

                <div class="mb-6 flex items-center gap-2">

                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="rounded border-gray-300 text-green-600"
                    >

                    <label
                        for="remember"
                        class="text-sm text-gray-600"
                    >
                        Ingat saya
                    </label>

                </div>


                {{-- BUTTON --}}

                <button
                    type="submit"
                    class="flex w-full items-center
                           justify-center gap-2
                           rounded-xl bg-green-600
                           px-4 py-3
                           font-semibold text-white
                           transition hover:bg-green-700"
                >
                    <i class="fa-solid fa-right-to-bracket"></i>

                    Login
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>