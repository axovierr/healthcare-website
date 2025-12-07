<x-guest-layout>

    <style>
        .bg-custom-green { background-color: #00D08E; }
        .text-custom-green { color: #00D08E; }
        .bg-custom-black { background-color: #1A1A1A; }
    </style>

    <!-- LOGO SECTION -->
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
            <h1 class="text-xl font-bold text-custom-black mb-1">Daftar Akun HealthCare</h1>
            <p class="text-sm text-gray-600">Nikmati kemudahan layanan kesehatan digital.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input 
                    id="name"
                    name="name"
                    type="text"
                    placeholder="Masukkan nama lengkap Anda"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    :value="old('name')"
                    required 
                    autofocus 
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" value="Email" />
                <x-text-input 
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Masukkan alamat email Anda"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    :value="old('email')"
                    required
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" value="Kata Sandi" />
                <x-text-input 
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Buat kata sandi"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    required
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                <x-text-input 
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="Ulangi kata sandi"
                    class="peer block mt-1 w-full rounded-lg border-gray-300 
                        focus:border-[#00D08E] focus:ring-[#00D08E]
                        peer-[&:not(:placeholder-shown)]:border-[#00D08E]"
                    required
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full py-3 bg-custom-green text-white font-semibold rounded-lg hover:opacity-90 transition">
                    Daftar
                </button>
            </div>

            <!-- Link to login -->
            <div class="mt-4 text-center text-sm">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-custom-green font-semibold hover:underline">
                        Masuk Sekarang
                    </a>
                </p>
            </div>

        </form>
    </div>

</x-guest-layout>
