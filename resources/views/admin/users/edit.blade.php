<x-layouts.admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Akun Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-xl font-semibold mb-6">Formulir Edit Akun</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Terdapat {{ $errors->count() }} kesalahan validasi.</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Field Nama -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Field Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Username Field -->
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Field Role -->
                        <div class="mb-4">
                            <label for="role_id" class="block text-sm font-medium text-gray-700">Peran Akun</label>
                            <select name="role_id" id="role_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                                onchange="toggleRoleFields(this.value)">
                                <option value="">-- Pilih Peran --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>
                                        {{ $role->display_name }} ({{ $role->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender Field -->
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="gender" id="gender" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $user->doctor->gender ?? $user->patient->gender ?? '') == 'male' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="female" {{ old('gender', $user->doctor->gender ?? $user->patient->gender ?? '') == 'female' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('gender') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Field Khusus Doctor -->
                        <div id="doctor-fields" class="hidden space-y-4">
                            <div class="mb-4">
                                <label for="license_no" class="block text-sm font-medium text-gray-700">Nomor Lisensi</label>
                                <input type="text" name="license_no" id="license_no" 
                                    value="{{ old('license_no', optional($user->doctor)->license_no) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                @error('license_no') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="address_clinic" class="block text-sm font-medium text-gray-700">Alamat Klinik</label>
                                <textarea name="address_clinic" id="address_clinic" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('address_clinic', optional($user->doctor)->address_clinic) }}</textarea>
                                @error('address_clinic') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Field Khusus Patient -->
                        <div id="patient-fields" class="hidden space-y-4">
                            <div class="mb-4">
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                    <option value="">Pilih Golongan Darah</option>
                                    @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                        <option value="{{ $goldar }}" 
                                            {{ old('golongan_darah', optional($user->patient)->golongan_darah) == $goldar ? 'selected' : '' }}>
                                            {{ $goldar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan_darah') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date" 
                                    value="{{ old('birth_date', optional($user->patient)->birth_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                @error('birth_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="address" id="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('address', optional($user->patient)->address) }}</textarea>
                                @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Field Password (Opsional untuk Edit) -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password Baru (Kosongkan jika tidak ingin mengubah)
                            </label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.users.index') }}" 
                               class="text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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
    
    // Jalankan saat halaman dimuat untuk menangani initial state
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role_id');
        if (roleSelect.value) {
            toggleRoleFields(roleSelect.value);
        }
    });
    </script>
</x-layouts.admin-layout>
