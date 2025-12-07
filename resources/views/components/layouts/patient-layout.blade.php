<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Dashboard</title>
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
            
            /* Sidebar Styling - derived from admin green but lighter/brighter tone for patient */
            .sidebar { background: linear-gradient(135deg, #36CFA0 0%, #1FA77F 100%); }
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
                /* patient accent: a lighter/softer green derived from admin */
                background-color: #66E0BF;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .nav-item:hover::before {
                opacity: 1;
            }

            /* Active state for current page */
            .nav-item.active {
                background-color: rgba(255,255,255,0.18);
                padding-left: 1.75rem;
            }
            .nav-item.active::before {
                opacity: 1;
            }

            /* Patient-specific table style (so it looks distinct from admin) */
            .patient-table thead th {
                background-color: transparent;
                color: #4B5563;
                font-weight: 600;
            }
            .patient-table tbody tr {
                background: white;
                border-bottom: 1px solid #EEF2F7;
            }
            .patient-table tbody tr:hover {
                background-color: #FBFDFF;
            }

            /* Profile card tweaks for patient pages */
            .profile-card {
                background: linear-gradient(180deg, rgba(255,255,255,0.9), white);
                border: 1px solid #E6F4EE;
                box-shadow: 0 4px 20px rgba(10, 20, 15, 0.03);
                border-radius: 12px;
            }
        </style>
    </head>
    <body class="bg-custom-light" style="color: #2D3748;">

        <div class="flex">

            {{-- Sidebar kiri --}}
            <aside class="sidebar w-64 min-h-screen text-white p-6 space-y-8 fixed h-screen overflow-y-auto">
                {{-- Logo Link ke Dashboard Pasien --}}
                <a href="{{ route('patient.dashboard') }}" class="flex items-center space-x-3 mb-8">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-10 w-auto">
                </a>

                <nav class="space-y-2">

                    {{-- 1. Dashboard --}}
                    <a href="{{ route('patient.dashboard') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" aria-current="{{ request()->routeIs('patient.dashboard') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-5-2l-4-2"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    {{-- 2. Janji Temu Saya --}}
                    <a href="{{ route('patient.appointments.index') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('patient.appointments*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('patient.appointments*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Janji Temu Saya</span>
                    </a>

                    {{-- 3. Rekam Medis --}}
                    <a href="{{ route('patient.medical-records.index') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('patient.medical-records*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('patient.medical-records*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Rekam Medis</span>
                    </a>

                    {{-- 4. Notifikasi --}}
                    <a href="{{ route('patient.notifications.index') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('patient.notifications*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('patient.notifications*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Notifikasi</span>
                    </a>

                    {{-- 5. Profil Saya --}}
                    <a href="{{ route('patient.profile.edit') }}"
                    class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('patient.profile*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('patient.profile*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil Saya</span>
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
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                {{ $slot }}
            </main>

        </div>

    </body>
</html>