<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthCare Website</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="icon" type="image/png" href="{{ asset('images/healthcare-logo.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

        <style>
            .bg-custom-green { background-color: #00D08E; }
            .text-custom-green { color: #00D08E; }
            .bg-custom-black { background-color: #1A1A1A; }
            .text-custom-black { color: #1A1A1A; }
            .bg-custom-light { background-color: #FFFFFF; }
        </style>
    </head>
    
    <body class="font-sans bg-custom-light text-custom-black">

        <!-- NAVIGATION -->
        <header class="sticky top-0 bg-white shadow-md z-50">
            <nav class="max-w-7xl mx-auto h-16 flex items-center justify-between px-6">
                
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo-healthcare.png') }}" alt="HealthCare Logo" class="h-8 w-auto">
                </a>

                <div class="lg:flex items-center space-x-8 text-sm font-medium">
                    <a href="#layanan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out">Layanan Kami</a>
                    <a href="#pesan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out">Cara Pemesanan</a>
                    <a href="#bantuan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out">Pusat Bantuan</a>
                </div>

                <div class="flex items-center space-x-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-md font-semibold border border-gray-300 rounded-full hover:bg-gray-100 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 text-md font-semibold bg-custom-green text-white rounded-full hover:bg-[#00B479] transition">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-3 py-2 text-md font-semibold bg-custom-black text-white rounded-full hover:bg-gray-800 transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

            </nav>
        </header>

        <!-- HERO SECTION -->
        <main class="pt-20 pb-32 bg-custom-green">
            <section id="hero" class="max-w-7xl mx-auto px-6 rounded-b-[40px]">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                    <!-- LEFT CONTENT -->
                    <div>
                        <h3 class="text-white text-3xl font-bold leading-tight">
                            #KesehatanSatuKlik
                        </h3>

                        <h1 class="text-white text-5xl font-extrabold mt-2 leading-tight">
                            Konsultasi Secara Instan, Tanpa Antre!
                        </h1>

                        <p class="text-white/90 text-lg mt-6 max-w-lg">
                            Pesan jadwal dokter spesialis Anda, akses rekam medis, resep obat, dan notifikasi kesehatan Anda secara digital.
                        </p>

                        <div class="flex items-center space-x-6 mt-10">
                            <a href="{{ route('login') }}" class="bg-white text-custom-green px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:scale-105 transition">
                                Jadwalkan Sekarang
                            </a>

                            <div class="text-left">
                                <p class="text-3xl font-extrabold text-white">★★★★☆ (4,5)</p>
                                <p class="text-sm text-white/80">Rating Pengguna</p>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT IMAGE -->
                    <div class="relative">
                        <img src="{{ asset('images/dokter-cover.png') }}" 
                            alt="Dokter Konsultasi Online"
                            class="w-full max-w-lg mx-auto rounded-xl">
                    </div>

                </div>
            </section>
        </main>

        <!-- STATISTIC BOX -->
        <section class="relative -mt-20 z-20">
            <div class="max-w-7xl mx-auto px-12">
                <div class="bg-white p-8 rounded-2xl shadow-xl border grid grid-cols-2 md:grid-cols-4 gap-4">

                    <div class="text-center">
                        <p class="text-4xl font-extrabold text-custom-green">750K+</p>
                        <p class="text-sm font-semibold pt-1">Penilaian</p>
                    </div>

                    <div class="text-center">
                        <p class="text-4xl font-extrabold text-custom-green">12+</p>
                        <p class="text-sm font-semibold pt-1">Tahun Berdiri</p>
                    </div>

                    <div class="text-center">
                        <p class="text-4xl font-extrabold text-custom-green">134+</p>
                        <p class="text-sm font-semibold pt-1">Dokter Spesialis</p>
                    </div>

                    <div class="text-center">
                        <p class="text-4xl font-extrabold text-custom-green">13M+</p>
                        <p class="text-sm font-semibold pt-1">Pengguna</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- LAYANAN KAMI -->
        <section id="layanan" class="pt-24 pb-20 bg-custom-light">
            <div class="max-w-7xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-custom-black mb-10">Layanan Kami</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">

                    <!-- Card -->
                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/profil-dokter.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Cek Profil Setiap Dokter</h3>
                        <p class="text-sm text-white/80">Lihat informasi lengkap dokter</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/janji-temu.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Janji Temu dengan Dokter</h3>
                        <p class="text-sm text-white/80">Atur jadwal konsul dengan mudah</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/record-medis.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Rekam Medis Digital Anda</h3>
                        <p class="text-sm text-white/80">Akses riwayat medis kapan saja</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/resep-obat.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Pelacakan Resep Obat</h3>
                        <p class="text-sm text-white/80">Pantau resep digital dengan mudah</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/riwayat-konsul.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Pencatatan Riwayat Konsul</h3>
                        <p class="text-sm text-white/80">Seluruh rekapan tersimpan aman</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/notification.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Sistem Notifikasi</h3>
                        <p class="text-sm text-white/80">Pengingat otomatis untuk Anda</p>
                    </article>

                </div>

            </div>
        </section>

        <!-- TENTANG KAMI -->
        <section id="tentang" class="py-8 bg-white">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                <img src="{{ asset('images/dokter-cover-2.png') }}" class="w-full h-auto" alt="Dokter">

                <article>
                    <h2 class="text-4xl font-bold text-custom-black">
                        Semua Dokter telah <br>
                        <span class="text-custom-green pt-1">Terverifikasi</span>
                    </h2>

                    <p class="mt-6 text-gray-600 leading-relaxed text-medium">
                        Seluruh prosedur layanan dan tenaga kesehatan yang terdaftar di HealthCare dipastikan memenuhi standar regulasi dan etika layanan kesehatan tertinggi. Kami menjamin bahwa setiap Dokter telah melalui proses verifikasi kredensial dan latar belakang praktik yang ketat sebelum dapat menerima janji temu.
                    </p>

                    <p class="mt-6 text-gray-600 leading-relaxed text-medium">
                        Selain itu, HealthCare secara berkala melakukan evaluasi kualitas layanan untuk memastikan setiap tenaga medis mempertahankan kompetensi profesionalnya. Mekanisme audit internal dan penilaian berbasis pengalaman pasien diterapkan agar standar keselamatan, kejelasan informasi, dan integritas praktik medis tetap terjaga. Dengan cara ini, setiap pengguna dapat mengakses layanan kesehatan yang akurat, transparan, dan dapat dipertanggungjawabkan.
                    </p>
                </article>

            </div>
        </section>

        <!-- CARA PESAN -->
        <section id="pesan" class="py-24 bg-custom-light">
            <div class="max-w-7xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-custom-black text-center mb-14">Cara Pesan Jadwal Dokter</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/profil.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Pilih Dokter & Jadwal</h3>
                        <p class="text-white/80 text-sm">Tentukan tanggal dan lihat slot waktu tersedia</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/validasi.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Konfirmasi & Validasi</h3>
                        <p class="text-white/80 text-sm">Pastikan tidak ada jadwal bentrok di waktu yang sama</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/bayar.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Transaksi Pembayaran</h3>
                        <p class="text-white/80 text-sm">Lakukan pembayaran untuk mengamankan slot</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition">
                        <img src="{{ asset('images/konfirmasi.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Konfirmasi Layanan</h3>
                        <p class="text-white/80 text-sm">Janji temu sudah aktif dan siap digunakan</p>
                    </article>

                </div>

            </div>
        </section>

        <section id="bantuan" class="py-16 bg-custom-light">
            <div class="max-w-7xl mx-auto px-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                <!-- Logo kiri -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-healthcare.png') }}" alt="Logo HealthCare" class="h-8 w-auto">
                </div>

                <!-- Link kanan -->
                <nav class="grid grid-cols-2 gap-6 text-sm text-gray-700">
                    <div class="space-y-3">
                        <p class="font-semibold text-custom-black">Layanan Kami</p>
                        <a href="#" class="block hover:text-custom-green transition">Cari Dokter</a>
                        <a href="#" class="block hover:text-custom-green transition">Buat Janji Temu</a>
                        <a href="#" class="block hover:text-custom-green transition">Lihat Rekam Medis</a>
                    </div>
                    <div class="space-y-3">
                        <p class="font-semibold text-custom-black">Bantuan & Info</p>
                        <a href="{{ url('/faqs') }}" class="block hover:text-custom-green transition">Pusat Bantuan FAQs</a>
                        <a href="{{ url('/privacy') }}" class="block hover:text-custom-green transition">Kebijakan Privasi</a>
                        <a href="{{ url('/terms') }}" class="block hover:text-custom-green transition">Syarat dan Ketentuan</a>
                    </div>
                </nav>

            </div>
        </section>

        <!-- FOOTER LANDING DI BAWAH SECTION PESAN -->
        <footer class="bg-custom-light border-none mt-8">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-4 lg:px-4 text-center text-sm text-gray-500"> 
                &copy; {{ date('Y') }} HealthCare System. Hak Cipta Dilindungi.
            </div>
        </footer>

    </body>
</html>