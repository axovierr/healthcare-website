<x-layouts.doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konsultasi dengan ') . $appointment->patient->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama Lengkap</p>
                            <p class="font-medium">{{ $appointment->patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $appointment->patient->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">No. Telepon</p>
                            <p class="font-medium">{{ $appointment->patient->phone_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Lahir</p>
                            <p class="font-medium">{{ $appointment->patient->date_of_birth ? \Carbon\Carbon::parse($appointment->patient->date_of_birth)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Kelamin</p>
                            <p class="font-medium">{{ $appointment->patient->gender ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Alamat</p>
                            <p class="font-medium">{{ $appointment->patient->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointment Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Detail Janji Temu</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tanggal</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Waktu</p>
                            <p class="font-medium">
                                @if($appointment->start_time && $appointment->end_time)
                                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipe Konsultasi</p>
                            <p class="font-medium">{{ $appointment->type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pembayaran</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Lunas
                            </span>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Keluhan</p>
                            <p class="font-medium">{{ $appointment->complaint }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Record Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Buat Rekam Medis</h3>
                    <form method="POST" action="{{ route('doctor.medical-records.store', $appointment) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="treatment" class="block text-sm font-medium text-gray-700">Pengobatan</label>
                            <textarea name="treatment" id="treatment" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                            <textarea name="notes" id="notes" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('doctor.appointments.today') }}" 
                                class="text-gray-600 hover:text-gray-900">
                                Kembali
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Rekam Medis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.doctor-layout>
