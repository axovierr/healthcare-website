<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                                :value="old('username', $patient->username ?? $user->username)"
                                required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('username')" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ (old('gender', $patient->gender ?? $user->gender) == 'male') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ (old('gender', $patient->gender ?? $user->gender) == 'female') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full"
                                :value="old('birth_date', optional($patient->birth_date)->format('Y-m-d') ?? '')"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                        </div>

                        <!-- Blood Type -->
                        <div>
                            <x-input-label for="golongan_darah" :value="__('Golongan Darah')" />
                            <select id="golongan_darah" name="golongan_darah" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ (old('golongan_darah', $patient->golongan_darah ?? '') == 'A') ? 'selected' : '' }}>A</option>
                                <option value="B" {{ (old('golongan_darah', $patient->golongan_darah ?? '') == 'B') ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ (old('golongan_darah', $patient->golongan_darah ?? '') == 'AB') ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ (old('golongan_darah', $patient->golongan_darah ?? '') == 'O') ? 'selected' : '' }}>O</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('golongan_darah')" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required>{{ old('address', $patient->address ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>