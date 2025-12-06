<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jadwal Dokter') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">{{ $doctor->user->name ?? $doctor->username }} — Jadwal</h3>
                    <div class="space-x-2">
                        <a href="{{ route('doctors.sessions.create', $doctor) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tambah Slot</a>
                        <form action="{{ route('doctors.sessions.generate', $doctor) }}" method="POST" class="inline">
                            @csrf
                            <input type="date" name="date" value="{{ now()->toDateString() }}" class="border rounded p-2" required />
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Generate 08:00-20:00</button>
                        </form>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $session)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $session->date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::createFromFormat('H:i:s', $session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->end_time)->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($session->booking && $session->booking->status === 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Booked (Paid)</span>
                                    @elseif($session->booking && $session->booking->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Booked (Pending)</span>
                                    @elseif(!$session->is_available)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not available</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(!$session->booking)
                                    <form action="{{ route('doctors.sessions.destroy', [$doctor, $session]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus slot ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                    @else
                                        <a href="#" class="text-gray-500">—</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $sessions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
