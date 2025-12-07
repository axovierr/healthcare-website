<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Dashboard</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/png" href="{{ asset('images/healthcare-logo.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-custom-green { background-color: #00A878; }
            .text-custom-green { color: #00A878; }
            .bg-custom-black { background-color: #1A1A1A; }
            .text-custom-black { color: #1A1A1A; }
            .bg-custom-light { background-color: #F5F7FA; }
            
            /* Sidebar Styling - derived from admin green but darker tone for doctor */
            .sidebar { background: linear-gradient(135deg, #007A5E 0%, #005F4B 100%); }
            .nav-item {
                transition: all 0.3s ease;
                position: relative;
            }
            .nav-item:hover {
                background-color: rgba(255, 255, 255, 0.15);
                padding-left: 1.75rem;
            }
            .nav-item::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 4px;
                /* doctor accent: a darker/muted green derived from admin */
                background-color: #00A07A;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .nav-item:hover::before {
                opacity: 1;
            }
        </style>
    </head>
    <body class="bg-custom-light" style="color: #2D3748;">

        <div class="flex">

            {{-- Sidebar kiri --}}
            <aside class="sidebar w-64 min-h-screen text-white p-6 space-y-8 fixed h-screen overflow-y-auto">
                {{-- Logo Link ke Dashboard Dokter --}}
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center space-x-3 mb-8">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-10 w-auto">
                </a>

                <nav class="space-y-2">

                    {{-- 1. Dashboard --}}
                    <a href="{{ route('doctor.dashboard') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-5-2l-4-2"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    {{-- 2. Jadwal Saya --}}
                    <a href="{{ route('doctor.schedule') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Jadwal Saya</span>
                    </a>

                    {{-- 3. Janji Temu Pasien --}}
                    <a href="{{ route('doctor.appointments.today') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Janji Temu Pasien</span>
                    </a>

                    {{-- 4. Rekam Medis --}}
                    <a href="{{ route('doctor.medical-records') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Rekam Medis</span>
                    </a>

                    {{-- 5. Riwayat Pasien --}}
                    <a href="{{ route('doctor.patient-history') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354L9 8.354m3-4L15 8.354m0 0a4 4 0 110-8.048M15 8.354L12 4.354m3 4l3-4m-9 16.5a6.5 6.5 0 1113 0H3"></path>
                        </svg>
                        <span>Riwayat Pasien</span>
                    </a>

                </nav>

                {{-- Tombol Logout --}}
                <div class="pt-6 border-t border-white/20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-3 font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Konten utama --}}
            <main class="flex-1 ml-64 p-8 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
                {{ $slot }}
            </main>

        </div>

    </body>
</html>