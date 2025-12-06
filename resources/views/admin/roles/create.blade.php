<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Role Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-xl font-semibold mb-6">Formulir Role Baru</h3>

                    <form method="POST" action="{{ route('admin.user-roles.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Role (Code)</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                required autofocus />
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                CONTOH: 'perawat' atau 'manajer'. <span class="font-bold text-red-600">HARUS UNIK</span> dan berbeda dari 'admin', 'doctor', atau 'patient'.
                            </p>
                        </div>
                        <div class="mb-6">
                            <label for="display_name" class="block text-sm font-medium text-gray-700">Nama Tampilan</label>
                            <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                required />
                            @error('display_name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Contoh: 'Administrator', 'Dokter Spesialis Jantung'.</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-lg font-medium text-gray-700 mb-3">Permissions yang Dimiliki</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($permissions as $permission)
                                    @php
                                        // Logika: Hanya cek input lama (old) jika validasi gagal
                                        $checked = in_array($permission->id, old('permissions', [])) ? 'checked' : '';
                                    @endphp

                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}" value="{{ $permission->id }}" 
                                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded" 
                                            {{ $checked }} />
                                        <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-900">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.user-roles.index') }}" class="mr-3 text-sm text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-black font-semibold rounded-lg hover:bg-indigo-700">
                                Simpan Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>