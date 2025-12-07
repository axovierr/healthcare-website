<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Dashboard</title>
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
                {{-- Logo Link ke Dashboard Dokter --}}
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-12 w-auto">
                </a>

                <nav class="space-y-3">

                    {{-- 1. Dashboard --}}
                    <a href="{{ route('doctor.dashboard') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('doctor.dashboard') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        <span>Dashboard</span>
                    </a>

                    {{-- 2. Jadwal Saya --}}
                    <a href="{{ route('doctor.schedule') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('doctor.schedule') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        <span>Jadwal Saya</span>
                    </a>

                    {{-- 3. Janji Temu Hari Ini --}}
                    <a href="{{ route('doctor.appointments.today') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('doctor.appointments.*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        <span>Janji Temu Pasien</span>
                    </a>

                    {{-- 4. Rekam Medis --}}
                    <a href="{{ route('doctor.medical-records') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('doctor.medical-records*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        <span>Rekam Medis</span>
                    </a>

                    {{-- 5. Riwayat Pasien --}}
                    <a href="{{ route('doctor.patient-history') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('doctor.patient-history') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        <span>Riwayat Pasien</span>
                    </a>

                </nav>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mt-4 w-full bg-red-600 p-3 font-semibold rounded hover:bg-red-700 transition">
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