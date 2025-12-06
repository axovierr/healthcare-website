<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Selamat datang, Administrator!</h3>
                    <p class="text-gray-600">Anda memiliki akses penuh ke sistem. Gunakan menu di bawah untuk mengelola pengguna dan peran.</p>
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Management Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Manajemen Pengguna</h3>
                        <p class="text-gray-600 mb-4">Tambah, edit, atau kelola akun pengguna sistem.</p>
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                            + Tambah Akun Baru
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-block ml-2 text-blue-500 hover:text-blue-600 font-semibold py-2 px-4">
                            Lihat Semua Akun →
                        </a>
                    </div>
                </div>
                <!-- Doctor Schedule Management Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Manajemen Jadwal Dokter</h3>
                        <p class="text-gray-600 mb-4">Kelola jadwal sesi dokter (08:00 - 20:00). Hanya admin yang dapat menambah/menghapus slot.</p>
                        <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kelola Jadwal Dokter</a>
                    </div>
                </div>

                <!-- Role Management Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Manajemen Peran</h3>
                        <p class="text-gray-600 mb-4">Kelola peran dan hak akses dalam sistem.</p>
                        <a href="{{ route('admin.user-roles.create') }}" 
                           class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                            + Tambah Peran Baru
                        </a>
                        <a href="{{ route('admin.user-roles.index') }}" 
                           class="inline-block ml-2 text-green-500 hover:text-green-600 font-semibold py-2 px-4">
                            Kelola Peran →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>