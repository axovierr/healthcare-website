<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daftar Dokter') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">Semua Dokter</h3>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($doctors as $doctor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->user->name ?? $doctor->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->user->email ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doctor->fee ? 'Rp '.number_format($doctor->fee,0,',','.') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('doctors.sessions.index', $doctor) }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Atur Jadwal</a>
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="px-3 py-1 bg-yellow-500 text-white rounded ml-2">Atur Biaya</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $doctors->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
