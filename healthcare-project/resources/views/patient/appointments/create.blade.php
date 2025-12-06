<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('patient.appointments.create') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Cari Dokter</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Nama atau spesialisasi...">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-indigo-600 px-4 py-2 text-sm text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Cari Dokter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Doctors List -->
            <div class="space-y-6">
                @forelse ($doctors as $doctor)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <div class="md:flex md:items-center md:justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <!-- Doctor Avatar -->
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <!-- Doctor Info -->
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                Dr. {{ $doctor->user->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $doctor->specialization ?? 'Dokter Umum' }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $doctor->address_clinic }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 flex flex-col items-end">
                                    <!-- Fee Info -->
                                    <div class="text-right mb-4">
                                        <p class="text-lg font-semibold text-gray-900">
                                            Rp {{ number_format($doctor->fee, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-500">per sesi</p>
                                    </div>
                                    <!-- View Schedule Button -->
                                    <a href="{{ route('patient.appointments.schedule', $doctor) }}" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                                        Lihat Jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Tidak ada dokter yang tersedia untuk kriteria pencarian Anda.
                        </div>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>