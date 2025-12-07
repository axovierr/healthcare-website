<x-layouts.admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Atur Dokter') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Atur Biaya & Informasi Klinik</h3>

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-400 text-red-700 p-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Dokter</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $doctor->user->name ?? $doctor->username }}</div>
                        </div>

                        <div>
                            <label for="fee" class="block text-sm font-medium text-gray-700">Biaya per sesi (Rp)</label>
                            <div class="mt-1">
                                <input type="number" step="0.01" name="fee" id="fee" value="{{ old('fee', $doctor->fee) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="100000">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Kosongkan untuk menggunakan default sistem.</p>
                        </div>

                        <div>
                            <label for="address_clinic" class="block text-sm font-medium text-gray-700">Alamat Klinik</label>
                            <div class="mt-1">
                                <textarea name="address_clinic" id="address_clinic" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('address_clinic', $doctor->address_clinic) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Kembali</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
