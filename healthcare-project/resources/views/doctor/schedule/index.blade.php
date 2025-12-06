<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Praktik') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Week Navigation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('doctor.schedule', ['week' => $currentWeek - 1]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Minggu Sebelumnya
                        </a>
                        
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}
                            </h3>
                            @if($currentWeek == 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Minggu Ini
                                </span>
                            @endif
                        </div>
                        
                        <a href="{{ route('doctor.schedule', ['week' => $currentWeek + 1]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Minggu Berikutnya →
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($schedules->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal</h3>
                            <p class="mt-1 text-sm text-gray-500">Admin belum mengatur jadwal praktik Anda.</p>
                        </div>
                    @else
                        @foreach($schedules as $date => $daySchedules)
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </h3>
                                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        @foreach($daySchedules as $schedule)
                                            <li>
                                                <div class="px-4 py-4 sm:px-6">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0">
                                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if($schedule->is_booked)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    Sudah Dibooking
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Tersedia
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>