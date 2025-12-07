<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Dashboard</title>
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
                {{-- Logo Link ke Dashboard Pasien --}}
                <a href="{{ route('patient.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-12 w-auto">
                </a>

                <nav class="space-y-3">

                    {{-- 1. Dashboard --}}
                    <a href="{{ route('patient.dashboard') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('patient.dashboard') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        {{-- Icon Dashboard --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    {{-- 2. Janji Temu Saya (Appointments) --}}
                    {{-- Mengarah ke index appointments (List Janji Temu) --}}
                    <a href="{{ route('patient.appointments.index') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('patient.appointments.*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        {{-- Icon Calendar --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Janji Temu Saya</span>
                    </a>

                    {{-- 3. Rekam Medis (Medical Records) --}}
                    <a href="{{ route('patient.medical-records.index') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('patient.medical-records.*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        {{-- Icon File Text --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Rekam Medis</span>
                    </a>

                    {{-- 4. Notifikasi --}}
                    <a href="{{ route('patient.notifications.index') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('patient.notifications.*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        {{-- Icon Bell --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span>Notifikasi</span>
                    </a>

                    {{-- 5. Profil Saya --}}
                    <a href="{{ route('patient.profile.edit') }}"
                    class="flex items-center font-medium gap-2 p-4 rounded hover:bg-white hover:text-[#009E84] hover:font-bold transition {{ request()->routeIs('patient.profile.*') ? 'bg-white text-[#009E84] font-bold' : '' }}">
                        {{-- Icon User --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil Saya</span>
                    </a>

                </nav>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mt-4 w-full bg-red-600 p-3 font-semibold rounded hover:bg-red-700 transition flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
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