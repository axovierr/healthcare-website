<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Janji Temu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <!-- Header -->
                    <div class="text-center pb-6 border-b">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold">Appointment #{{ $appointment->id }}</h3>
                        <p class="text-gray-600 mt-2">
                            @if($appointment->payment_status === 'paid')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    ✓ Lunas
                                </span>
                            @elseif($appointment->payment_status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                    ⏱ Menunggu Pembayaran
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                    {{ ucfirst($appointment->payment_status ?? 'pending') }}
                                </span>
                            @endif
                        </p>
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

                    <!-- Appointment Details -->
                    <div class="border rounded-lg p-6">
                        <h4 class="font-semibold text-lg mb-4">Detail Konsultasi</h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Dokter:</dt>
                                <dd class="font-semibold">{{ optional(optional($appointment->doctor)->user)->name ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Spesialisasi:</dt>
                                <dd class="font-semibold">{{ $appointment->doctor->specialization ?? 'Dokter Umum' }}</dd>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Tanggal:</dt>
                                <dd class="font-semibold">{{ optional($scheduledDate)->format('d M Y') ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Waktu:</dt>
                                <dd class="font-semibold">
                                    {{ $startTime ? \Illuminate\Support\Carbon::parse($startTime)->format('H:i') : '-' }}
                                    -
                                    {{ $endTime ? \Illuminate\Support\Carbon::parse($endTime)->format('H:i') : '-' }}
                                </dd>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Tipe:</dt>
                                <dd class="font-semibold">{{ $appointment->type ?? 'Offline' }}</dd>
                            </div>
                            <div class="flex justify-between border-b pb-3">
                                <dt class="text-gray-600">Status Janji:</dt>
                                <dd class="font-semibold">{{ $appointment->status ?? 'Scheduled' }}</dd>
                            </div>
                            <div class="flex justify-between items-center pt-3">
                                <dt class="font-semibold text-lg">Biaya Konsultasi:</dt>
                                <dd class="text-2xl font-bold text-blue-600">Rp {{ number_format($appointment->consultation_fee ?? 0, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Payment Actions -->
                    @if($appointment->payment_status === 'pending' && !$appointment->isPaymentExpired())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800 mb-3">
                                <strong>⚠️ Pembayaran Diperlukan</strong><br>
                                Silakan lanjutkan ke pembayaran untuk mengonfirmasi janji temu Anda.
                            </p>
                            <a href="{{ route('patient.payments.show', $appointment) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center">
                                💳 Lanjutkan Pembayaran
                            </a>
                        </div>
                    @elseif($appointment->payment_status === 'paid')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-sm text-green-800">
                                <strong>✓ Pembayaran Berhasil</strong><br>
                                Dibayar pada: {{ optional($appointment->paid_at)->format('d M Y, H:i') ?? '-' }} WIB
                            </p>
                        </div>
                    @elseif($appointment->isPaymentExpired())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-sm text-red-800">
                                <strong>⚠️ Pembayaran Kedaluwarsa</strong><br>
                                Batas waktu pembayaran telah habis. Silakan buat janji temu baru.
                            </p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <a href="{{ route('patient.appointments.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded text-center">
                            ← Kembali ke Daftar
                        </a>
                        <a href="{{ route('patient.dashboard') }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded text-center">
                            🏠 Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>
