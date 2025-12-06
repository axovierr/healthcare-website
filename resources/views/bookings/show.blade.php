<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Booking') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium mb-4">Booking #{{ $booking->id }}</h3>

                <p><strong>Dokter:</strong> {{ $booking->session->doctor->user->name ?? $booking->session->doctor->username }}</p>
                <p><strong>Tanggal:</strong> {{ $booking->session->date->format('Y-m-d') }}</p>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->session->end_time)->format('H:i') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($booking->status ?? 'pending') }}</p>

                <div class="mt-6">
                    <a href="{{ route('patient.appointments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali ke Janji Temu</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>