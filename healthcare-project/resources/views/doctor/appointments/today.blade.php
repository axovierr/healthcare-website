<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Janji Temu Hari Ini') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($appointments->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada janji temu</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda tidak memiliki janji temu dengan pasien untuk hari ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Pasien
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($appointment->start_time && $appointment->end_time)
                                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                                @elseif($appointment->schedule)
                                                    {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($appointment->schedule->end_time)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $appointment->patient->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $appointment->patient->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(strtolower($appointment->status) === 'scheduled')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Terjadwal
                                                    </span>
                                                @elseif(strtolower($appointment->status) === 'completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Selesai
                                                    </span>
                                                @elseif(strtolower($appointment->status) === 'cancelled')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Dibatalkan
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $appointment->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if(strtolower($appointment->status) === 'scheduled')
                                                    <a href="{{ route('doctor.appointments.start', $appointment) }}" 
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                        Mulai Konsultasi
                                                    </a>
                                                @elseif(strtolower($appointment->status) === 'completed')
                                                    @if($appointment->medical_record)
                                                        <a href="{{ route('medical-records.show', $appointment->medical_record) }}"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                            Lihat Rekam Medis
                                                        </a>
                                                    @else
                                                        <a href="{{ route('doctor.medical-records.create', $appointment) }}" 
                                                            class="text-green-600 hover:text-green-900">
                                                            Buat Rekam Medis
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>