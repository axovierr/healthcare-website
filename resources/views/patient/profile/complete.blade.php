<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('patient.profile.store') }}" class="space-y-6">
                        @csrf

                        <!-- Username Field -->
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username', auth()->user()->username)" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Gender Field -->
                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <!-- Birth Date Field -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" required />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <!-- Blood Type Field -->
                        <div>
                            <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                            <select id="golongan_darah" name="golongan_darah" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                            <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                        </div>

                        <!-- Address Field -->
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Simpan Profil') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>