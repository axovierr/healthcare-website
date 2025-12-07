<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menunggu Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Payment Status -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Menunggu Pembayaran</h3>
                        <p class="text-gray-600">Appointment #{{ $appointment->id }}</p>
                    </div>

                    <!-- Virtual Account Info -->
                    <div class="border rounded-lg p-4 mb-6 bg-gray-50">
                        <p class="text-sm text-gray-600 mb-2">Nomor Virtual Account:</p>
                        <div class="flex items-center gap-2">
                            <input type="text" value="{{ $appointment->va_number }}" id="va-number" readonly
                                class="flex-1 font-mono text-lg font-semibold bg-white border-gray-300 rounded-md px-4 py-2">
                            <button onclick="copyVA()" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded whitespace-nowrap">
                                Copy
                            </button>
                        </div>
                    </div>

                    <!-- Appointment Info -->
                    <div class="border rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-lg mb-4">Detail Konsultasi</h4>
                        
                        @php
                            $schedule = $appointment->schedule;
                            $scheduledDateValue = $schedule?->date ?? $appointment->date;
                            $startTime = $schedule?->start_time ?? $appointment->start_time;
                            $endTime = $schedule?->end_time ?? $appointment->end_time;
                            $scheduledDate = $scheduledDateValue
                                ? \Illuminate\Support\Carbon::parse($scheduledDateValue)
                                : null;
                        @endphp

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dokter:</span>
                                <span class="font-semibold">{{ optional(optional($appointment->doctor)->user)->name ?? '-' }}</span>
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
                        </div>

                        <div class="border-t mt-4 pt-4 flex justify-between items-center">
                            <span class="font-semibold">Total Pembayaran:</span>
                            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($appointment->consultation_fee ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Expired Info -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">⏰ Batas Waktu Pembayaran:</span><br>
                            {{ optional($appointment->expired_at)->format('d M Y, H:i') ?? '-' }} WIB
                        </p>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h5 class="font-semibold mb-2">Cara Pembayaran:</h5>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-gray-700">
                            <li>Klik tombol "Buka Halaman Pembayaran" di bawah</li>
                            <li>Di halaman payment gateway, lakukan pembayaran</li>
                            <li>Setelah pembayaran berhasil, halaman ini akan otomatis mendeteksi dan redirect ke halaman sukses</li>
                            <li>Atau klik tombol "Cek Status Pembayaran Sekarang" untuk refresh manual</li>
                        </ol>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        <a href="{{ $appointment->payment_url }}" target="_blank" class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                            🔗 Buka Halaman Pembayaran (Tab Baru)
                        </a>
                        
                        <button onclick="checkPaymentNow()" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                            🔄 Cek Status Pembayaran Sekarang
                        </button>
                        
                        <a href="{{ route('patient.appointments.index') }}" class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center">
                            ← Kembali ke Daftar Appointment
                        </a>
                    </div>

                    <!-- Auto Refresh Status -->
                    <p class="text-center text-sm text-gray-500 mt-6">
                        <span class="inline-block animate-pulse">●</span> 
                        Halaman akan otomatis diperbarui setiap 10 detik
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyVA() {
            const vaInput = document.getElementById('va-number');
            vaInput.select();
            vaInput.setSelectionRange(0, 99999); // For mobile devices
            
            try {
                document.execCommand('copy');
                alert('✓ Nomor Virtual Account berhasil dicopy!');
            } catch (err) {
                alert('Gagal copy. Silakan copy manual.');
            }
        }

        // Manual check payment status
        function checkPaymentNow() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '⏳ Mengecek...';
            
            const checkUrl = '{{ route("patient.payments.check-status", $appointment) }}';
            console.log('Checking payment status at:', checkUrl);
            
            fetch(checkUrl)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Payment status response:', data);
                    if (data.status === 'paid') {
                        btn.innerHTML = '✓ Pembayaran Berhasil! Redirecting...';
                        setTimeout(() => {
                            window.location.href = '{{ route("patient.payments.success", $appointment) }}';
                        }, 1000);
                    } else {
                        alert('Status: ' + (data.status || 'Masih Pending') + '\n\nPembayaran belum terdeteksi. Silakan coba lagi.');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    alert('Gagal mengecek status: ' + error.message + '\n\nSilakan refresh halaman atau cek console untuk detail.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        }

        // Auto check payment status every 10 seconds
        setInterval(function() {
            fetch('{{ route("patient.payments.check-status", $appointment) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        window.location.href = '{{ route("patient.payments.success", $appointment) }}';
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }, 10000);
    </script>
</x-layouts.patient-layout>
