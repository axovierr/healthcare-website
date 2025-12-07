<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/png" href="{{ asset('images/healthcare-logo.png') }}">
        <style>
            .bg-custom-green { background-color: #009E84; }
            .text-custom-green { color: #009E84; }
            .bg-custom-black { background-color: #1A1A1A; }
            .text-custom-black { color: #1A1A1A; }
            .bg-custom-light { background-color: #FFFFFF; }
        </style>
    </head>
        <body class="bg-custom-light">

        <div class="flex">

            {{-- Sidebar kiri --}}
            <aside class="w-64 bg-custom-green min-h-screen text-white font-medium p-6 space-y-6">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-12 w-auto">
                </a>

                <nav class="space-y-3">

                    <a href="/admin/dashboard"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Dashboard</span>
                    </a>

                    <a href="/admin/users"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Kelola Pengguna</span>
                    </a>

                    <a href="/admin/user-roles"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Role / Peran</span>
                    </a>

                    <a href="/admin/doctors"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Dokter dan Jadwal</span>
                    </a>

                    <a href="#"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Transaksi</span>
                    </a>

                    <a href="#"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Arsip</span>
                    </a>

                    <a href="#"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition">
                        <span>Pengaturan</span>
                    </a>

                </nav>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mt-4 w-full bg-red-600 p-3 font-semibold rounded hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </aside>

            {{-- Konten utama --}}
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>

        </div>

    </body>
</html>