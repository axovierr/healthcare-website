<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2 text-gray-800">Arsip Rekam Medis & Resep</h1>
        <p class="text-gray-600">Lihat semua riwayat rekam medis dan resep dokter</p>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6 section-header">
            <h3 class="heading-4">Data Rekam Medis dan Resep Dokter</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID RM</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Kunjungan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Pasien</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dokter</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Diagnosis</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Resep Obat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archives as $record)
                        <tr class="table-row hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">#{{ $record->id }}</span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-600">
                                    {{ date('d M Y', strtotime($record->visit_date ?? now())) }}
                                </p>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 text-xs font-semibold mr-2">
                                        {{ substr($record->patient->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $record->patient->user->name ?? 'N/A' }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 text-xs font-semibold mr-2">
                                        {{ substr($record->doctor->user->name ?? 'D', 0, 1) }}
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">{{ $record->doctor->user->name ?? 'N/A' }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block max-w-xs px-3 py-1 rounded-lg bg-blue-50 text-blue-900 text-sm">
                                    {{ $record->diagnosis ?? 'Tidak ada' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="max-w-xs space-y-1">
                                    @forelse($record->prescriptions as $prescription)
                                        <div class="text-xs bg-amber-50 border-l-2 border-amber-400 p-2 rounded">
                                            <p class="font-semibold text-amber-900">{{ $prescription->medication }}</p>
                                            <p class="text-amber-700">Dosis: {{ $prescription->dosage }}</p>
                                        </div>
                                    @empty
                                        <span class="text-xs text-gray-400">Tidak ada resep</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 max-w-xs line-clamp-2">{{ $record->doctor_notes ?? '-' }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">Belum ada arsip rekam medis</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $archives->links() }}</div>
    </div>
</x-layouts.admin-layout>