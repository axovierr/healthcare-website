<x-layouts.doctor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Medical Record Details') }}
            </h2>
            @if(auth()->user()->hasRole('doctor') && $medicalRecord->appointment->doctor_id === auth()->user()->doctor->id)
                <a href="{{ route('medical-records.edit', $medicalRecord->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Record
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Appointment Info</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $medicalRecord->visit_date->format('d M Y') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Doctor</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $medicalRecord->appointment->doctor->user->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Patient</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $medicalRecord->appointment->patient->user->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Complaint</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $medicalRecord->appointment->complaint }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Medical Details</h3>
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Diagnosis</h4>
                                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $medicalRecord->diagnosis }}</p>
                            </div>
                            
                            @if($medicalRecord->doctor_notes)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Doctor Notes</h4>
                                <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded whitespace-pre-line">{{ $medicalRecord->doctor_notes }}</p>
                            </div>
                            @endif

                            @if($medicalRecord->attachment_path)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Hasil Pemeriksaan</h4>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $medicalRecord->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        View Attachment
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($medicalRecord->prescriptions->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Resep Obat</h4>
                                <div class="bg-gray-50 rounded-lg overflow-hidden border">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dosis</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aturan Pakai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($medicalRecord->prescriptions as $prescription)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->medication }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->dosage }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->instructions }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('medical-records.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.doctor-layout>
