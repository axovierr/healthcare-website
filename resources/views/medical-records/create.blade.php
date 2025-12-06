<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Medical Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Patient Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Name: {{ $appointment->patient->user->name }}</p>
                        <p class="mt-1 text-sm text-gray-600">Appointment Date: {{ $appointment->date->format('d M Y') }}</p>
                        <p class="mt-1 text-sm text-gray-600">Complaint: {{ $appointment->complaint }}</p>
                    </div>

                    <form method="POST" action="{{ route('doctor.medical-records.store', $appointment->id) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Diagnosis -->
                        <div class="mb-4">
                            <x-input-label for="diagnosis" :value="__('Diagnosis')" />
                            <textarea id="diagnosis" name="diagnosis" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('diagnosis') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                        </div>

                        <!-- Doctor Notes -->
                        <div class="mb-4">
                            <x-input-label for="doctor_notes" :value="__('Doctor Notes (Optional)')" />
                            <textarea id="doctor_notes" name="doctor_notes" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('doctor_notes') }}</textarea>
                            <x-input-error :messages="$errors->get('doctor_notes')" class="mt-2" />
                        </div>

                        <!-- Attachment -->
                        <div class="mb-4">
                            <x-input-label for="attachment" :value="__('Upload Hasil Pemeriksaan (Optional)')" />
                            <input id="attachment" name="attachment" type="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="mt-1 text-sm text-gray-500">PDF, JPG, or PNG (Max. 2MB).</p>
                            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                        </div>

                        <!-- Prescriptions -->
                        <div class="mb-6" x-data="{ 
                            prescriptions: [] 
                        }">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-lg font-medium text-gray-900">Resep Obat</h3>
                                <button type="button" @click="prescriptions.push({ medication: '', dosage: '', instructions: '' })" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + Tambah Obat
                                </button>
                            </div>
                            
                            <template x-for="(prescription, index) in prescriptions" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-3 p-4 border rounded-lg bg-gray-50 relative">
                                    <div class="md:col-span-4">
                                        <x-input-label :value="__('Nama Obat')" />
                                        <input type="text" :name="'prescriptions['+index+'][medication]'" x-model="prescription.medication" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Contoh: Paracetamol">
                                    </div>
                                    <div class="md:col-span-3">
                                        <x-input-label :value="__('Dosis')" />
                                        <input type="text" :name="'prescriptions['+index+'][dosage]'" x-model="prescription.dosage" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Contoh: 500mg">
                                    </div>
                                    <div class="md:col-span-4">
                                        <x-input-label :value="__('Aturan Pakai')" />
                                        <input type="text" :name="'prescriptions['+index+'][instructions]'" x-model="prescription.instructions" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Contoh: 3x1 sesudah makan">
                                    </div>
                                    <div class="md:col-span-1 flex items-end justify-center pb-1">
                                        <button type="button" @click="prescriptions.splice(index, 1)" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="prescriptions.length === 0" class="text-sm text-gray-500 italic mb-2">
                                Belum ada obat yang ditambahkan. Klik tombol di atas untuk menambah resep.
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save Record') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
