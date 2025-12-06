<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat Datang!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">Terima kasih telah mendaftar!</h3>
                        <p class="text-gray-600 mb-4">Untuk dapat menggunakan layanan kami secara penuh, mohon lengkapi data profil Anda terlebih dahulu.</p>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Data yang perlu dilengkapi meliputi:
                                    </p>
                                    <ul class="list-disc list-inside mt-2 text-sm text-blue-700">
                                        <li>Tanggal Lahir</li>
                                        <li>Jenis Kelamin</li>
                                        <li>Golongan Darah</li>
                                        <li>Alamat</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('patient.profile.complete') }}" 
                               class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                                Lengkapi Profil Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>