<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Konfirmasi Pembayaran</h3>
                        <p class="text-gray-600">Appointment #{{ $appointment->id }}</p>
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

                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="font-semibold text-lg mb-4">Detail Konsultasi</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dokter:</span>
                                <span class="font-semibold">{{ optional(optional($appointment->doctor)->user)->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Spesialisasi:</span>
                                <span class="font-semibold">{{ $appointment->doctor->specialization ?? 'Dokter Umum' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-semibold">{{ optional($scheduledDate)->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu:</span>
                                <span class="font-semibold">
                                    {{ $startTime ? \Illuminate\Support\Carbon::parse($startTime)->format('H:i') : '-' }}
                                    -
                                    {{ $endTime ? \Illuminate\Support\Carbon::parse($endTime)->format('H:i') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center border-t pt-3">
                                <span class="font-semibold">Biaya Konsultasi</span>
                                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($appointment->consultation_fee ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-gray-700">
                        <p class="font-semibold mb-2">Catatan:</p>
                        <p>Nomor Virtual Account akan dibuat setelah Anda menekan tombol "Buat Virtual Account" di bawah ini.</p>
                        <p class="mt-2">Pastikan data janji temu sudah sesuai sebelum melanjutkan proses pembayaran.</p>
                        <p class="mt-2">Setelah pembayaran berhasil, status appointment akan otomatis berubah menjadi <strong>Lunas</strong>.</p>
                    </div>

                    <div class="flex gap-4">
                        <form action="{{ route('patient.payments.process', $appointment) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded">
                                Buat Virtual Account
                            </button>
                        </form>
                        <a href="{{ route('patient.appointments.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded text-center">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>