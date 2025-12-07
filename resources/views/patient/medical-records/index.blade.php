<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekam Medis Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-600 mb-6">Akses riwayat kesehatan dan rekam medis Anda dari setiap konsultasi</p>

                    @if($medicalRecords->count() > 0)
                        <div class="space-y-4">
                            @foreach($medicalRecords as $record)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $record->appointment->patient->user->name ?? ($record->appointment->patient->user->name ?? '-') }}</h4>
                                            <p class="text-sm text-gray-600">{{ $record->visit_date->format('d M Y') }}</p>
                                            <div class="mt-2">
                                                <p class="text-sm"><strong>Diagnosis:</strong> {{ $record->diagnosis ?? '-' }}</p>
                                                <p class="text-sm"><strong>Keluhan:</strong> {{ $record->appointment->complaint ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('medical-records.show', $record->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
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
                                <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + Buat Janji Temu
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>