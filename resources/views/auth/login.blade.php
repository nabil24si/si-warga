<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiWarga') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900 selection:bg-slate-900 selection:text-white">
    <div class="flex min-h-screen">
        
        <!-- Left Side: Image & Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 p-3 sm:p-4">
            <div class="relative w-full h-full rounded-[2rem] overflow-hidden shadow-2xl flex flex-col justify-between p-10 sm:p-14" style="background-image: url('https://i.ibb.co.com/m5tRNWxt/jembatan.jpg'); background-size: cover; background-position: center;">
                <!-- Overlay gradient for readability -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-slate-900/20 to-slate-900/80"></div>
                
                <!-- Top Brand -->
                <div class="relative z-10 self-start bg-white/80 backdrop-blur-md p-3 sm:p-4 rounded-2xl shadow-lg border border-white/50">
                    <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="w-40 sm:w-48 lg:w-56 h-auto object-contain drop-shadow-sm">
                </div>

                <!-- Bottom Text -->
                <div class="relative z-10 self-start max-w-lg bg-white/80 backdrop-blur-md p-6 rounded-3xl shadow-xl border border-white/50">
                    <h1 class="text-5xl font-extrabold tracking-tight mb-4 leading-[1.1] uppercase text-[#1a365d]">
                        Portal Digital<br><span class="text-[#d4af37]">Warga Modern!</span>
                    </h1>
                    <p class="text-base text-[#1a365d] font-medium mb-5 leading-relaxed">
                        Masuk untuk mengakses layanan administrasi persuratan, pelaporan infrastruktur, dan informasi kegiatan komunitas secara transparan dari pengurus RT/RW Anda.
                    </p>
                    <p class="text-sm font-bold text-[#d4af37] uppercase tracking-widest">
                        Perjalanan Anda dimulai di sini.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24">
            <div class="w-full max-w-md">
                
                <!-- Mobile Logo (visible only on small screens) -->
                <div class="lg:hidden mb-10 flex justify-center">
                    <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="h-14 w-auto">
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-3 uppercase tracking-tight">Welcome Back !</h2>
                    <p class="text-slate-500 font-medium">Selamat datang kembali! Silakan masukkan akun Anda.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="block w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm placeholder-slate-400 transition duration-200 shadow-sm"
                            placeholder="Enter your email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm placeholder-slate-400 transition duration-200 shadow-sm"
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-2">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer transition duration-150">
                            <span class="ms-2 text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition duration-150">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-slate-900 hover:text-blue-600 transition duration-150" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#0f3741] hover:bg-[#0a262d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f3741] transition-all duration-200">
                            Sign in
                        </button>
                    </div>
                </form>

                <!-- Footer Sign Up -->
                <p class="mt-10 text-center text-sm text-slate-500 font-medium">
                    Don't have an account? <a href="{{ route('register') }}" class="font-bold text-slate-900 hover:text-blue-600 transition duration-150">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
