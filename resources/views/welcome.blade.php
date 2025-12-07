<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthCare - Konsultasi Kesehatan Digital Terpercaya</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="icon" type="image/png" href="{{ asset('images/healthcare-logo.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; }
            
            .bg-custom-green { background-color: #00A878; }
            .text-custom-green { color: #00A878; }
            .bg-custom-black { background-color: #1A1A1A; }
            .text-custom-black { color: #1A1A1A; }
            .bg-custom-light { background-color: #FFFFFF; }
            
            /* Hero Gradient */
            .hero-gradient {
                background: linear-gradient(135deg, #00A878 0%, #008B6B 50%, #006B55 100%);
            }

            /* Smooth Animations */
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes slideInLeft { from { opacity: 0; transform: translateX(-36px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes slideInRight { from { opacity: 0; transform: translateX(36px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes slideInDown { from { opacity: 0; transform: translateY(-18px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
            @keyframes pulse-glow { 0%,100% { box-shadow: 0 0 0 0 rgba(0,168,120,0.28); } 50% { box-shadow: 0 0 0 10px rgba(0,168,120,0); } }

            /* Animation utility classes */
            .animate-fade-in-up { animation: fadeInUp 0.75s cubic-bezier(.2,.9,.3,1) both; }
            .animate-slide-in-left { animation: slideInLeft 0.72s cubic-bezier(.2,.9,.3,1) both; }
            .animate-slide-in-right { animation: slideInRight 0.72s cubic-bezier(.2,.9,.3,1) both; }
            .animate-slide-in-down { animation: slideInDown 0.6s cubic-bezier(.2,.9,.3,1) both; }
            .animate-float { animation: float 3.6s ease-in-out infinite; }
            .animate-pulse-glow { animation: pulse-glow 2.2s infinite; }

            /* Small helpers for staggered delays (non-intrusive) */
            .anim-delay-1 { animation-delay: 0.08s; }
            .anim-delay-2 { animation-delay: 0.18s; }
            .anim-delay-3 { animation-delay: 0.32s; }
            .anim-delay-4 { animation-delay: 0.46s; }
            .anim-delay-5 { animation-delay: 0.62s; }

            /* Subtle hover & micro-interaction helpers */
            .service-card { transition: transform .28s ease, box-shadow .28s ease; }
            .service-card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 12px 30px rgba(13,60,46,0.12); }

            .btn-primary { display:inline-block; padding: .9rem 2rem; border-radius: 9999px; font-weight:700; font-size:1.05rem; transition: transform .18s ease, box-shadow .18s ease; background-color:#ffffff; color:#00A878; text-decoration:none; }
            .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
            .btn-primary:focus{ outline:none; box-shadow:0 6px 18px rgba(0,168,120,0.12); }

            .btn-secondary { padding: .9rem 2rem; border-radius: 9999px; font-weight:700; }

            nav a { transition: all .28s cubic-bezier(.2,.9,.3,1); }

            .stat-box { text-align:center; padding:1.25rem; transition: background-color .28s ease, transform .28s ease; }
            .stat-box:hover { transform: translateY(-6px); }

            .section-title { font-size:1.9rem; font-weight:800; margin-bottom:3rem; text-align:center; color:#0f172a; }

            .highlight-text { background: linear-gradient(90deg,#00A878,#00D08E); -webkit-background-clip:text; background-clip:text; color:transparent; }
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
                    <a href="#layanan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out animate-slide-in-down anim-delay-1">Layanan Kami</a>
                    <a href="#pesan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out animate-slide-in-down anim-delay-2">Cara Pemesanan</a>
                    <a href="#bantuan" class="sm:text-md text-base font-lg bg-black hover:bg-gradient-to-r from-[#00BD81] to-[#00D08E] bg-clip-text text-transparent hover:opacity-100 transition-all duration-300 ease-in-out animate-slide-in-down anim-delay-3">Pusat Bantuan</a>
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
                        <h3 class="text-white text-3xl font-bold leading-tight animate-slide-in-left anim-delay-1">#KesehatanSatuKlik</h3>

                        <h1 class="text-white text-5xl font-extrabold mt-2 leading-tight animate-fade-in-up anim-delay-2">Konsultasi Secara Instan, Tanpa Antre!</h1>

                        <p class="text-white/90 text-lg mt-6 max-w-lg animate-fade-in-up anim-delay-3">Pesan jadwal dokter spesialis Anda, akses rekam medis, resep obat, dan notifikasi kesehatan Anda secara digital.</p>

                        <div class="flex items-center space-x-6 mt-10">
                            <a href="{{ route('login') }}" class="bg-white text-custom-green px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:scale-105 transition animate-fade-in-up anim-delay-2">
                                Jadwalkan Sekarang
                            </a>

                            <div class="text-left animate-fade-in-up anim-delay-4">
                                <p class="text-3xl font-extrabold text-white">★★★★☆ (4,5)</p>
                                <p class="text-sm text-white/80">Rating Pengguna</p>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT IMAGE -->
                    <div class="relative">
                        <img src="{{ asset('images/dokter-cover.png') }}" 
                            alt="Dokter Konsultasi Online"
                            class="w-full max-w-lg mx-auto rounded-xl animate-float animate-slide-in-right anim-delay-2">
                    </div>

                </div>
            </section>
        </main>

        <!-- STATISTIC BOX -->
        <section class="relative -mt-20 z-20">
            <div class="max-w-7xl mx-auto px-12">
                <div class="bg-white p-8 rounded-2xl shadow-xl border grid grid-cols-2 md:grid-cols-4 gap-4">

                    <div class="text-center stat-box animate-fade-in-up anim-delay-1">
                        <p class="text-4xl font-extrabold text-custom-green">750K+</p>
                        <p class="text-sm font-semibold pt-1">Ulasan Positif</p>
                    </div>

                    <div class="text-center stat-box animate-fade-in-up anim-delay-2">
                        <p class="text-4xl font-extrabold text-custom-green">12+</p>
                        <p class="text-sm font-semibold pt-1">Tahun Berdiri</p>
                    </div>

                    <div class="text-center stat-box animate-fade-in-up anim-delay-3">
                        <p class="text-4xl font-extrabold text-custom-green">134+</p>
                        <p class="text-sm font-semibold pt-1">Dokter Spesialis</p>
                    </div>

                    <div class="text-center stat-box animate-fade-in-up anim-delay-4">
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

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Card -->
                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-1">
                        <img src="{{ asset('images/profil-dokter.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Cek Profil Setiap Dokter</h3>
                        <p class="text-sm text-white/80">Lihat informasi lengkap dokter</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-2">
                        <img src="{{ asset('images/janji-temu.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Janji Temu dengan Dokter</h3>
                        <p class="text-sm text-white/80">Atur jadwal konsul dengan mudah</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-3">
                        <img src="{{ asset('images/record-medis.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Rekam Medis Digital Anda</h3>
                        <p class="text-sm text-white/80">Akses riwayat medis kapan saja</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-4">
                        <img src="{{ asset('images/resep-obat.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Pelacakan Resep Obat</h3>
                        <p class="text-sm text-white/80">Pantau resep digital dengan mudah</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-5">
                        <img src="{{ asset('images/riwayat-konsul.png') }}" class="h-10 mb-4" alt="">
                        <h3 class="font-semibold text-lg mb-1">Pencatatan Riwayat Konsul</h3>
                        <p class="text-sm text-white/80">Seluruh rekapan tersimpan aman</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-6 rounded-2xl text-white shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-5">
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

                <img src="{{ asset('images/dokter-cover-2.png') }}" class="w-full h-auto animate-float anim-delay-2 animate-fade-in-up" alt="Dokter">

                <article>
                    <h2 class="text-4xl font-bold text-custom-black animate-slide-in-left anim-delay-2">
                        Semua Dokter telah <br>
                        <span class="text-custom-green pt-1">Terverifikasi</span>
                    </h2>

                    <p class="mt-6 text-gray-600 leading-relaxed text-medium animate-fade-in-up anim-delay-3">
                        Seluruh prosedur layanan dan tenaga kesehatan yang terdaftar di HealthCare dipastikan memenuhi standar regulasi dan etika layanan kesehatan tertinggi. Kami menjamin bahwa setiap Dokter telah melalui proses verifikasi kredensial dan latar belakang praktik yang ketat sebelum dapat menerima janji temu.
                    </p>

                    <p class="mt-6 text-gray-600 leading-relaxed text-medium animate-fade-in-up anim-delay-4">
                        Selain itu, HealthCare secara berkala melakukan evaluasi kualitas layanan untuk memastikan setiap tenaga medis mempertahankan kompetensi profesionalnya. Mekanisme audit internal dan penilaian berbasis pengalaman pasien diterapkan agar standar keselamatan, kejelasan informasi, dan integritas praktik medis tetap terjaga. Dengan cara ini, setiap pengguna dapat mengakses layanan kesehatan yang akurat, transparan, dan dapat dipertanggungjawabkan.
                    </p>

                <!-- Trust / Certification badges -->
                <div class="mt-6 flex flex-wrap gap-3 items-center animate-fade-in-up anim-delay-5">
                    <span class="flex items-center bg-green-50 text-custom-green px-3 py-2 rounded-full text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
                        Sertifikasi Terpercaya
                    </span>

                    <span class="flex items-center bg-green-50 text-custom-green px-3 py-2 rounded-full text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M9 12a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L9 9.586l5.293-5.293a1 1 0 011.414 1.414l-6 6A1 1 0 019 12z"/></svg>
                        Audit & Evaluasi Berkala
                    </span>

                    <span class="flex items-center bg-green-50 text-custom-green px-3 py-2 rounded-full text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2a2 2 0 00-2 2v1H6a2 2 0 00-2 2v3c0 3 2 5 6 6 4-1 6-3 6-6V7a2 2 0 00-2-2h-2V4a2 2 0 00-2-2z"/></svg>
                        Tenaga Medis Terverifikasi
                    </span>

                    <span class="flex items-center bg-green-50 text-custom-green px-3 py-2 rounded-full text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zM11 7h2v6h-2V7zm0 8h2v2h-2v-2z"/></svg>
                        Keamanan Data & Privasi
                    </span>
                </div>
                </article>

            </div>
        </section>

        <!-- CARA PESAN -->
        <section id="pesan" class="py-24 bg-custom-light">
            <div class="max-w-7xl mx-auto px-6">

                <h2 class="text-3xl font-bold text-custom-black text-center mb-14">Cara Pesan Jadwal Dokter</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-1">
                        <img src="{{ asset('images/profil.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Pilih Dokter & Jadwal</h3>
                        <p class="text-white/80 text-sm">Tentukan tanggal dan lihat slot waktu tersedia</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-2">
                        <img src="{{ asset('images/validasi.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Konfirmasi & Validasi</h3>
                        <p class="text-white/80 text-sm">Pastikan tidak ada jadwal bentrok di waktu yang sama</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-3">
                        <img src="{{ asset('images/bayar.png') }}" class="h-14 mx-auto mb-4" alt="">
                        <h3 class="font-bold text-lg mb-2">Transaksi Pembayaran</h3>
                        <p class="text-white/80 text-sm">Lakukan pembayaran untuk mengamankan slot</p>
                    </article>

                    <article class="bg-gradient-to-r from-[#00BD81] to-[#00D08E] p-8 rounded-xl text-white text-center shadow-md hover:scale-105 transition service-card animate-fade-in-up anim-delay-4">
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
                <div class="flex items-center space-x-3 animate-slide-in-left anim-delay-1">
                    <img src="{{ asset('images/logo-healthcare.png') }}" alt="Logo HealthCare" class="h-8 w-auto">
                </div>

                <!-- Link kanan -->
                <nav class="grid grid-cols-2 gap-6 text-sm text-gray-700 animate-fade-in-up anim-delay-2">
                    <div class="space-y-3">
                        <p class="font-semibold text-custom-black">Layanan Kami</p>
                        <a href="{{ url('/cari-dokter') }}" class="block hover:text-custom-green transition">Cari Dokter</a>
                        <a href="{{ url('/buat-janji') }}" class="block hover:text-custom-green transition">Buat Janji Temu</a>
                        <a href="{{ url('/rekam-medis') }}" class="block hover:text-custom-green transition">Lihat Rekam Medis</a>
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
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-4 lg:px-4 text-center text-sm text-gray-500 animate-fade-in-up anim-delay-3"> 
                &copy; {{ date('Y') }} HealthCare System. Hak Cipta Dilindungi.
            </div>
        </footer>

    </body>
</html>
