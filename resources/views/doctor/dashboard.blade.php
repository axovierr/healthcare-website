<x-layouts.doctor-layout>
    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100">
            <p class="text-sm text-gray-500">Dashboard Dokter</p>
            <h2 class="text-2xl font-semibold text-gray-900 mt-2">
                Selamat datang, {{ $doctor->user->name ?? Auth::user()->name }}!
            </h2>
            <p class="mt-3 text-gray-600 leading-relaxed">
                Pantau aktivitas klinis Anda. Mulai dari janji temu, jadwal praktik, hingga rekam medis pasien tersedia dalam satu tempat.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Janji Hari Ini</div>
                <div class="text-4xl font-bold text-custom-green">{{ $todayAppointments }}</div>
                <p class="text-sm text-gray-500">Pasien yang telah melakukan booking dan siap Anda layani hari ini.</p>
                <a href="{{ route('doctor.appointments.today') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg bg-custom-green text-white font-semibold hover:bg-[#007a63] transition">
                    Lihat Jadwal Konsultasi
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Jadwal Praktik</div>
                <div class="text-4xl font-bold text-custom-green">
                    08:00 - 20:00
                </div>
                <p class="text-sm text-gray-500">Pantau slot praktik yang dibuat admin dan pastikan tetap tersedia untuk pasien.</p>
                <a href="{{ route('doctor.schedule') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg border border-custom-green text-custom-green font-semibold hover:bg-custom-green transition">
                    Kelola Jadwal Minggu Ini
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Rekam Medis</div>
                <div class="text-4xl font-bold text-custom-green">
                    Real-time
                </div>
                <p class="text-sm text-gray-500">Perbarui catatan medis pasien supaya tim lain dapat mengakses informasi terbaru.</p>
                <a href="{{ route('doctor.medical-records') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg bg-custom-black text-white font-semibold hover:bg-[#0f0f0f] transition">
                    Buka Rekam Medis
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pasien</h3>
                        <p class="text-sm text-gray-500">Lihat pasien terakhir yang Anda tangani.</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-custom-green rounded-full">Aktif</span>
                </div>
                <p class="text-gray-600">Pantau resume konsultasi, resep obat, dan tindak lanjut pasien secara menyeluruh.</p>
                <a href="{{ route('doctor.patient-history') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-6 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Lihat Riwayat Pasien
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tips Operasional</h3>
                        <p class="text-sm text-gray-500">Pastikan sesi online berjalan lancar.</p>
                    </div>
                    <img src="{{ asset('images/profil-dokter.png') }}" alt="Doctor Illustration" class="h-12 w-12 object-contain">
                </div>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Siapkan link telemedicine dan kirim melalui fitur notifikasi pasien.</li>
                    <li>• Update status janji temu setelah sesi selesai.</li>
                    <li>• Tandai catatan penting langsung di rekam medis pasien.</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.doctor-layout>