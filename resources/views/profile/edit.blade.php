<x-layouts.admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold mb-2 text-gray-800">Pengaturan Profil</h1>
        <p class="text-gray-600">Kelola informasi profil, kata sandi, dan pengaturan akun Anda</p>
    </div>

    <div class="grid gap-6">
        <!-- Update Profile Information -->
        <div class="card p-8 bg-gradient-to-br from-white to-blue-50 border-l-4 border-blue-500">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Informasi Profil</h2>
                    <p class="text-sm text-gray-500">Perbarui informasi pribadi Anda</p>
                </div>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card p-8 bg-gradient-to-br from-white to-amber-50 border-l-4 border-amber-500">
            <div class="flex items-center mb-6">
                <div class="bg-amber-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Perbarui Kata Sandi</h2>
                    <p class="text-sm text-gray-500">Ubah kata sandi akun Anda</p>
                </div>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card p-8 bg-gradient-to-br from-white to-red-50 border-l-4 border-red-500">
            <div class="flex items-center mb-6">
                <div class="bg-red-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0H8m4 0h4M7 20h10a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v9a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Hapus Akun</h2>
                    <p class="text-sm text-gray-500">Hapus akun dan semua data Anda secara permanen</p>
                </div>
            </div>
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
