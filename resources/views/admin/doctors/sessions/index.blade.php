<x-layouts.admin-layout>
    <div class="mb-6">
        <h1 class="heading-2 mb-2">Manajemen Jadwal Dokter</h1>
        <p class="text-gray-600">Kelola jadwal konsultasi untuk {{ $doctor->user->name ?? $doctor->username }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="card p-6 mb-6">
        <div class="flex justify-between items-center mb-6 section-header">
            <h3 class="heading-4">{{ $doctor->user->name ?? $doctor->username }} — Jadwal Slot</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('doctors.sessions.create', $doctor) }}" class="btn btn-primary flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Slot Baru
            </a>

            <form action="{{ route('doctors.sessions.generate', $doctor) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="date" name="date" value="{{ now()->toDateString() }}" class="flex-1 input" required />
                <button type="submit" class="btn btn-success px-4">Generate 08:00-20:00</button>
            </form>
        </div>
    </div>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr class="table-row hover:bg-blue-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900">{{ $session->date->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->end_time)->format('H:i') }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($session->booking && $session->booking->status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <svg class="w-2 h-2 mr-1 rounded-full bg-red-600"></svg>
                                        Terbayar
                                    </span>
                                @elseif($session->booking && $session->booking->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <svg class="w-2 h-2 mr-1 rounded-full bg-yellow-600"></svg>
                                        Tertunda
                                    </span>
                                @elseif(!$session->is_available)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        <svg class="w-2 h-2 mr-1 rounded-full bg-gray-600"></svg>
                                        Tidak Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <svg class="w-2 h-2 mr-1 rounded-full bg-green-600"></svg>
                                        Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if(!$session->booking)
                                    <form action="{{ route('doctors.sessions.destroy', [$doctor, $session]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus slot ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">Belum ada jadwal</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $sessions->links() }}
        </div>
    </div>
</x-layouts.admin-layout>
