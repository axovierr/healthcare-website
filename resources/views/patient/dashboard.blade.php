<x-layouts.patient-layout>
    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <p class="text-sm text-gray-500">Dashboard Pasien</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">
                    Halo, {{ Auth::user()->name }} 👋
                </h2>
                <p class="mt-3 text-gray-600 leading-relaxed">
                    Pantau janji temu, pembayaran, dan hasil konsultasi Anda pada satu tempat yang nyaman.
                </p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('patient.appointments.create') }}"
                   class="px-5 py-3 rounded-xl bg-custom-green text-white font-semibold hover:bg-[#007a63] transition">
                    + Buat Janji Baru
                </a>
                <a href="{{ route('patient.profile.edit') }}"
                   class="px-5 py-3 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Lengkapi Profil
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Janji Mendatang</div>
                <div class="text-4xl font-bold text-custom-green">Terjadwal</div>
                <p class="text-sm text-gray-600">
                    Lihat status janji Anda, mulai dari persiapan hingga pembayaran.
                </p>
                <a href="{{ route('patient.appointments.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg bg-custom-green text-white font-semibold hover:bg-[#007a63] transition">
                    Lihat Daftar Janji
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Rekam Medis</div>
                <div class="text-4xl font-bold text-custom-black">Lengkap</div>
                <p class="text-sm text-gray-600">
                    Akses catatan dokter, resep, dan riwayat tindakan kapanpun diperlukan.
                </p>
                <a href="{{ route('patient.medical-records.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg border border-custom-green text-custom-green font-semibold hover:bg-custom-green hover:text-white transition">
                    Buka Rekam Medis
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 flex flex-col gap-3">
                <div class="text-sm text-gray-500 uppercase tracking-wide">Notifikasi Dokter</div>
                <div class="text-4xl font-bold text-custom-green">Real-time</div>
                <p class="text-sm text-gray-600">
                    Cek link konsultasi online, pesan dokter, dan tindak lanjut penting.
                </p>
                <a href="{{ route('patient.notifications.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-auto rounded-lg bg-custom-black text-white font-semibold hover:bg-black transition">
                    Lihat Notifikasi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Status Pembayaran</h3>
                        <p class="text-sm text-gray-500">Pantau pembayaran konsultasi Anda.</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Butuh cek rutin</span>
                </div>
                <p class="text-gray-600">
                    Lanjutkan pembayaran yang tertunda dan simpan bukti lunas Anda secara digital.
                </p>
                <a href="{{ route('patient.appointments.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 mt-6 rounded-lg border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Kelola Pembayaran
                </a>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tips Konsultasi</h3>
                        <p class="text-sm text-gray-500">Persiapkan diri sebelum sesi dimulai.</p>
                    </div>
                    <img src="{{ asset('images/dokter-cover-2.png') }}" alt="Patient Tips" class="h-14 w-14 object-contain rounded-lg">
                </div>
                <ul class="text-gray-600 space-y-2 text-sm">
                    <li>• Pastikan data profil Anda lengkap untuk memudahkan dokter menganalisa.</li>
                    <li>• Periksa notifikasi secara berkala untuk mengetahui link telemedicine.</li>
                    <li>• Simpan catatan obat dan keluhan terbaru pada menu rekam medis.</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.patient-layout>