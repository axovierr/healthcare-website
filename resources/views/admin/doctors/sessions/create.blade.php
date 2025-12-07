<x-layouts.admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Slot Jadwal') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium mb-4">Tambah Slot untuk {{ $doctor->user->name ?? $doctor->username }}</h3>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border-l-4 border-red-400 text-red-700 p-4">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('doctors.sessions.store', $doctor) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="mt-1 block w-full border rounded p-2" required />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jam Mulai (HH:MM)</label>
                        <input type="time" name="start_time" value="{{ old('start_time', '08:00') }}" class="mt-1 block w-full border rounded p-2" required />
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('doctors.sessions.index', $doctor) }}" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Slot</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
