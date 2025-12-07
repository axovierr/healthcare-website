<x-guest-layout>

    <style>
        .bg-custom-green { background-color: #00D08E; }
        .text-custom-green { color: #00D08E; }
        .bg-custom-black { background-color: #1A1A1A; }
        .ring-custom-green { background-color: #00D08E; }
        .ring-custom-black { background-color: #1A1A1A; }
    </style>

    <!-- LOGO SECTION (benar-benar terpisah dari form) -->
    <div class="mt-5 flex flex-col items-center">
        <a href="{{ url('/') }}">
            <img 
                src="{{ asset('images/logo-healthcare.png') }}" 
                alt="HealthCare Logo" 
                class="h-12 w-auto"
            />
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="w-full sm:max-w-md mt-6 mx-auto bg-white px-6 py-6 rounded-xl shadow-lg border">

        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-custom-black mb-1">Masuk ke Akun HealthCare Anda</h1>
            <p class="text-sm text-gray-600">Layanan Kesehatan Anda, Hanya dengan Sekali Klik.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" value="Email" />
                <x-text-input 
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Masukkan alamat email terdaftar Anda"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    required
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4 mb-4">
                <x-input-label for="password" value="Kata Sandi" />
                <x-text-input 
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan kata sandi Anda"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    required
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-between items-center text-sm">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-custom-green shadow-sm focus:ring-custom-green" name="remember">
                    <span class="ms-2 text-gray-600">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-gray-600 hover:text-custom-green" href="{{ route('password.request') }}">
                        Lupa Kata Sandi?
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full py-3 bg-custom-green text-white font-semibold rounded-lg hover:opacity-90 transition">
                    Log In
                </button>
            </div>

            <div class="mt-4 text-center text-sm">
                <p class="text-gray-600">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="text-custom-green font-semibold hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

        </form>
    </div>

</x-guest-layout>
