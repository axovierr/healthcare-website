<x-layouts.admin-layout>

    {{-- Header Welcome --}}
    <div class="card mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-custom-green">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat datang, Administrator!</h1>
                <p class="text-gray-600">Kelola sistem kesehatan digital dengan mudah dari dashboard ini.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
                <p class="text-lg font-semibold text-custom-green">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card Pasien --}}
        <div class="card p-6 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Jumlah Pasien</p>
                    <h3 class="text-4xl font-bold text-custom-green">{{ $totalPasien }}</h3>
                    <p class="text-xs text-gray-500 mt-2">↑ 12% dari bulan lalu</p>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-custom-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card Dokter --}}
        <div class="card p-6 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Jumlah Dokter</p>
                    <h3 class="text-4xl font-bold text-blue-600">{{ $totalDokter }}</h3>
                    <p class="text-xs text-gray-500 mt-2">Aktif & tersedia</p>
                </div>
                <div class="bg-gradient-to-br from-blue-100 to-blue-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-2m0 0H8m4 0v2m0-2v-2m8 6a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card Janji Temu --}}
        <div class="card p-6 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Janji Temu</p>
                    <h3 class="text-4xl font-bold text-purple-600">{{ $totalJanjiTemu }}</h3>
                    <p class="text-xs text-gray-500 mt-2">Bulan ini</p>
                </div>
                <div class="bg-gradient-to-br from-purple-100 to-purple-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Card Pendapatan --}}
        <div class="card p-6 hover:shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Pendapatan</p>
                    <h3 class="text-3xl font-bold text-amber-600">Rp 12,45M</h3>
                    <p class="text-xs text-gray-500 mt-2">↑ 8.2% dari kemarin</p>
                </div>
                <div class="bg-gradient-to-br from-amber-100 to-amber-50 p-4 rounded-full">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="/admin/users" class="btn-primary px-4 py-3 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition text-center">
                    Kelola Pengguna
                </a>
                <a href="/admin/doctors" class="btn-primary px-4 py-3 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition text-center">
                    Dokter & Jadwal
                </a>
                <a href="/admin/transactions" class="btn-primary px-4 py-3 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition text-center">
                    Transaksi
                </a>
                <a href="/admin/archive" class="btn-primary px-4 py-3 bg-amber-600 text-white rounded-lg text-sm font-medium hover:bg-amber-700 transition text-center">
                    Arsip Data
                </a>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Sistem</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                    <span class="text-gray-600">Status Server</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">🟢 Online</span>
                </li>
                <li class="flex justify-between items-center pb-2 border-b border-gray-200">
                    <span class="text-gray-600">Database</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">🟢 Connected</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-gray-600">Versi Sistem</span>
                    <span class="text-gray-800 font-medium">v1.0.0</span>
                </li>
            </ul>
        </div>
    </div>

</x-layouts.admin-layout>
