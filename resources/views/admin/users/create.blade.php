<x-layouts.admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Akun Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-xl font-semibold mb-6">Formulir Akun Baru</h3>

                    <!-- Tampilkan error validasi global jika ada -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            Terdapat {{ $errors->count() }} kesalahan validasi.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- Field Nama -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Field Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Field Role (DROPDOWN DARI DATABASE) -->
                        <div class="mb-4">
                            <label for="role_id" class="block text-sm font-medium text-gray-700">Pilih Peran Akun</label>
                            <select name="role_id" id="role_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                                onchange="toggleRoleFields(this.value)">
                                <option value="">-- Pilih Peran --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->display_name }} ({{ $role->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username Field -->
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender Field (Untuk Semua Role) -->
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="gender" id="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Field Khusus Doctor -->
                        <div id="doctor-fields" class="hidden space-y-4">
                            <div class="mb-4">
                                <label for="license_no" class="block text-sm font-medium text-gray-700">Nomor Lisensi Dokter</label>
                                <input type="text" name="license_no" id="license_no" value="{{ old('license_no') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                @error('license_no')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="address_clinic" class="block text-sm font-medium text-gray-700">Alamat Klinik</label>
                                <textarea name="address_clinic" id="address_clinic" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('address_clinic') }}</textarea>
                                @error('address_clinic')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Field Khusus Patient -->
                        <div id="patient-fields" class="hidden space-y-4">
                            <div class="mb-4">
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                                @error('golongan_darah')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                @error('birth_date')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="address" id="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Field Password -->
                        
                        <script>
                        function toggleRoleFields(roleId) {
                            // Sembunyikan semua field khusus
                            document.getElementById('doctor-fields').classList.add('hidden');
                            document.getElementById('patient-fields').classList.add('hidden');
                            
                            // Ambil nama role dari option yang dipilih
                            const selectedOption = document.querySelector(`option[value="${roleId}"]`);
                            if (!selectedOption) return;
                            
                            const roleName = selectedOption.textContent.toLowerCase();
                            
                            // Tampilkan field sesuai role
                            if (roleName.includes('doctor')) {
                                document.getElementById('doctor-fields').classList.remove('hidden');
                            } else if (roleName.includes('patient')) {
                                document.getElementById('patient-fields').classList.remove('hidden');
                            }
                        }
                        
                        // Jalankan saat halaman dimuat untuk menangani old input
                        document.addEventListener('DOMContentLoaded', function() {
                            const roleSelect = document.getElementById('role_id');
                            if (roleSelect.value) {
                                toggleRoleFields(roleSelect.value);
                            }
                        });
                        </script>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <!-- Tombol Kembali -->
                            <a href="{{ route('admin.users.index') }}" class="mr-3 text-sm text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                                Simpan Akun Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
