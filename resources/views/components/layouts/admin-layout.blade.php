<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
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
            
            /* Sidebar Styling */
            .sidebar { background: linear-gradient(135deg, #00A878 0%, #008B6B 100%); }
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
                background-color: #00D08E;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .nav-item:hover::before {
                opacity: 1;
            }
            
            /* Card Styling */
            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                border: 1px solid #E8EDF2;
            }
            .card:hover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
                transform: translateY(-2px);
            }
            
            /* Button Styling */
            .btn-primary {
                background: linear-gradient(135deg, #00A878 0%, #008B6B 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(0, 168, 120, 0.3);
            }
            
            /* Table Styling */
            .table-header {
                background-color: #F5F7FA;
                border-bottom: 2px solid #E8EDF2;
            }
            .table-row {
                border-bottom: 1px solid #E8EDF2;
                transition: background-color 0.2s ease;
            }
            .table-row:hover {
                background-color: #F9FAFB;
            }
        </style>
    </head>
    <body class="bg-custom-light" style="color: #2D3748;">
        <div class="flex min-h-screen">
            {{-- Sidebar kiri --}}
            <aside class="sidebar w-64 min-h-screen text-white p-6 space-y-8 fixed h-screen overflow-y-auto">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center space-x-3 mb-8">
                    <img src="{{ asset('images/white-healthcare.png') }}" alt="HealthCare Logo" class="h-10 w-auto">
                </a>

                <nav class="space-y-2">
                    <a href="/admin/dashboard" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-5-2l-4-2"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="/admin/users" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354L9 8.354m3-4L15 8.354m0 0a4 4 0 110-8.048M15 8.354L12 4.354m3 4l3-4m-9 16.5a6.5 6.5 0 1113 0H3"></path>
                        </svg>
                        <span>Kelola Pengguna</span>
                    </a>

                    <a href="/admin/user-roles" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Role / Peran</span>
                    </a>

                    <a href="/admin/doctors" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Dokter & Jadwal</span>
                    </a>

                    <a href="/admin/transactions" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Transaksi</span>
                    </a>

                    <a href="/admin/archive" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9-4v4m0 0v4"></path>
                        </svg>
                        <span>Arsip</span>
                    </a>

                    <a href="/profile" class="nav-item flex items-center font-medium gap-3 px-4 py-3 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </nav>

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
