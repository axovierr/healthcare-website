<x-layouts.admin-layout>

    {{-- konten dashboard tetap sama yang sekarang --}}
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mb-6 p-6">
        <h3 class="text-lg font-semibold mb-2">Selamat datang, Administrator!</h3>
        <p class="text-gray-600">Anda memiliki akses penuh ke sistem. Gunakan menu di kiri untuk navigasi.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card 1 --}}
        <div class="bg-custom-light shadow-sm rounded-lg p-8 text-center border-[#009E84] border-2">
            <h4 class="text-4xl font-bold text-custom-green">{{ $totalPasien }}</h4>
            <p class="text-gray-500 text-sm mb-1">Jumlah Pasien</p>
        </div>

        {{-- Card 2 --}}
        <div class="bg-custom-light shadow-sm rounded-lg p-8 text-center border-[#009E84] border-2">
            <h4 class="text-4xl font-bold text-custom-green">{{ $totalDokter }}</h4>
            <p class="text-gray-500 text-sm mb-1">Jumlah Dokter</p>
        </div>

        {{-- Card 3 --}}
        <div class="bg-custom-light shadow-sm rounded-lg p-8 text-center border-[#009E84] border-2">
            <h4 class="text-4xl font-bold text-custom-green">{{ $totalJanjiTemu }}</h4>
            <p class="text-gray-500 text-sm mb-1">Jumlah Janji Temu</p>
        </div>

        {{-- Card 4 --}}
        <div class="bg-custom-light shadow-sm rounded-lg p-8 text-center border-[#009E84] border-2">
            <h4 class="text-4xl font-bold text-custom-green">Rp12.450.000</h4>
            <p class="text-gray-500 text-sm mb-1">Pendapatan</p>
        </div>
    </div>

</x-layouts.admin-layout>
