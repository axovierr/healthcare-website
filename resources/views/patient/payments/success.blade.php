<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Berhasil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-600 mb-2">Pembayaran Berhasil!</h3>
                        <p class="text-gray-600">Appointment #{{ $appointment->id }} telah dikonfirmasi.</p>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 text-green-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>
                                Pembayaran diterima pada {{ optional($appointment->paid_at)->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                    </div>

                    @php
                        $schedule = $appointment->schedule;
                        $scheduledDateValue = $schedule?->date ?? $appointment->date;
                        $startTime = $schedule?->start_time ?? $appointment->start_time;
                        $endTime = $schedule?->end_time ?? $appointment->end_time;
                        $scheduledDate = $scheduledDateValue
                            ? \Illuminate\Support\Carbon::parse($scheduledDateValue)
                            : null;
                    @endphp

                    <div class="border rounded-lg p-6">
                        <h4 class="font-semibold text-lg mb-4">Detail Konsultasi</h4>
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">No. Appointment:</span>
                                <span class="font-semibold">#{{ $appointment->id }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">Dokter:</span>
                                <span class="font-semibold">{{ optional(optional($appointment->doctor)->user)->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">Spesialisasi:</span>
                                <span class="font-semibold">{{ $appointment->doctor->specialization ?? 'Dokter Umum' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-semibold">{{ optional($scheduledDate)->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">Waktu:</span>
                                <span class="font-semibold">
                                    {{ $startTime ? \Illuminate\Support\Carbon::parse($startTime)->format('H:i') : '-' }}
                                    -
                                    {{ $endTime ? \Illuminate\Support\Carbon::parse($endTime)->format('H:i') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    ✓ Confirmed
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="font-semibold text-lg">Total Dibayar:</span>
                                <span class="text-2xl font-bold text-green-600">Rp {{ number_format($appointment->consultation_fee ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h5 class="font-semibold text-blue-800 mb-2">Catatan Penting:</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-blue-900">
                            <li>Harap datang 15 menit sebelum jadwal konsultasi.</li>
                            <li>Bawa kartu identitas dan bukti pembayaran.</li>
                            <li>Jika ada perubahan, hubungi customer service.</li>
                            <li>Bukti appointment telah dikirim ke email Anda.</li>
                        </ul>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('patient.appointments.show', $appointment) }}" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center">
                             Lihat Detail Appointment
                        </a>
                        <a href="{{ route('patient.appointments.index') }}" class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center">
                             Lihat Semua Appointment
                        </a>
                        <a href="{{ route('patient.dashboard') }}" class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                             Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>