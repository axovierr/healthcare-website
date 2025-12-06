<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekam Medis Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($medicalRecords->count() > 0)
                        <div class="space-y-4">
                            @foreach($medicalRecords as $record)
                                <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $record->visit_date->format('d M Y') }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                Dokter: {{ $record->appointment->doctor->user->name ?? '-' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('medical-records.show', $record->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                                            Lihat Detail
                                        </a>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Diagnosis</h4>
                                            <p class="text-gray-900">{{ $record->diagnosis ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-700 mb-1">Keluhan</h4>
                                            <p class="text-gray-900">{{ $record->appointment->complaint ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $medicalRecords->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Rekam Medis</h3>
                            <p class="mt-1 text-sm text-gray-500">Rekam medis akan muncul setelah Anda melakukan konsultasi dengan dokter.</p>
                            <div class="mt-6">
                                <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    + Buat Janji Temu
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
