<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-center">
        <div class="flex justify-center mb-6">
            <svg class="w-16 h-16 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h2 class="text-2xl font-extrabold text-slate-900 mb-4">Pendaftaran Berhasil!</h2>
        <p class="text-slate-600 font-medium leading-relaxed">
            Akun Anda saat ini sedang dalam proses verifikasi oleh Pengurus RT/RW. 
            Silakan cek kembali secara berkala atau hubungi pengurus setempat jika butuh bantuan lebih lanjut.
        </p>
    </div>

    <div class="mt-8 flex justify-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-bold">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
