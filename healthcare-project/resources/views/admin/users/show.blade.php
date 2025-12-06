<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Umum</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                                <p class="mt-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Username</p>
                                <p class="mt-1">{{ $user->username }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Peran</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->role->display_name }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($user->role->name === 'doctor')
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Dokter</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nomor Lisensi</p>
                                <p class="mt-1">{{ $user->doctor->license_no }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                                <p class="mt-1">{{ $user->doctor->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Alamat Klinik</p>
                                <p class="mt-1">{{ $user->doctor->address_clinic }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($user->role->name === 'patient')
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pasien</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Golongan Darah</p>
                                <p class="mt-1">{{ $user->patient->golongan_darah }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                                <p class="mt-1">{{ $user->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tanggal Lahir</p>
                                <p class="mt-1">{{ \Carbon\Carbon::parse($user->patient->birth_date)->format('d F Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="mt-1">{{ $user->patient->address }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-end space-x-4">
                        @if($user->role->name === 'doctor' && $user->doctor)
                            <a href="{{ route('doctors.sessions.index', $user->doctor) }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Kelola Jadwal Dokter
                            </a>
                        @endif

                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('admin.users.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>