<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2 text-gray-800">Riwayat Transaksi & Janji Temu</h1>
        <p class="text-gray-600">Kelola semua transaksi dan janji temu berbayar</p>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6 section-header">
            <h3 class="heading-4">Semua Janji Temu Berbayar</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Pasien</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dokter</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Biaya</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Sesi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Pembayaran</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status Konsultasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="table-row hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">#{{ $appointment->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 text-xs font-semibold mr-2">
                                        {{ substr($appointment->patient->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 text-xs font-semibold mr-2">
                                        {{ substr($appointment->doctor->user->name ?? 'D', 0, 1) }}
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->doctor->user->name ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-600">{{ date('d M Y', strtotime($appointment->date)) }}</p>
                                <p class="text-xs text-gray-500">{{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-custom-green">
                                    {{ 'Rp' . number_format($appointment->fee, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($appointment->telemedicineSession)
                                    <a href="{{ $appointment->telemedicineSession->meet_link }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Akses
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($appointment->payment_status == 'paid') bg-green-100 text-green-800
                                    @elseif($appointment->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($appointment->payment_status == 'paid')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    @endif
                                    {{ ucfirst($appointment->payment_status ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    {{ ucfirst($appointment->status ?? 'N/A') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-gray-500 font-medium">Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    </div>
</x-layouts.admin-layout>