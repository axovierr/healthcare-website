<x-layouts.patient-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Notifikasi</h3>

                    <div class="flex flex-col divide-y divide-gray-200 border border-gray-200 rounded-md">
                        
                        @forelse($notifications as $notification)
                            <div class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="text-md font-bold text-gray-800">
                                            {{ $notification->title }}
                                        </h5>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $notification->message }}
                                        </p>
                                        <div class="mt-2 text-xs text-indigo-600 font-semibold">
                                            Dari: Dr. {{ $notification->doctor->name ?? 'Dokter' }}
                                        </div>
                                    </div>
                                    
                                    <small class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <p>Tidak ada notifikasi baru.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>