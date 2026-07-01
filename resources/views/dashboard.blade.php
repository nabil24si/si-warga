<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
        @if ($user->role === 'rw')
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-slate-900">Selamat Datang, Pengurus RW</h3>
                <p class="text-gray-600 mt-1">Berikut adalah ringkasan data RW Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total RT</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $totalRt }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                Tetap
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Warga</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $totalWarga }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Aktif
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Menunggu Persetujuan</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $pendingWarga }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                Perlu Aksi
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center text-amber-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

        @elseif ($user->role === 'rt')
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-slate-900">Selamat Datang, Pengurus RT {{ $user->rt_number }}</h3>
                <p class="text-gray-600 mt-1">Berikut adalah ringkasan data RT Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Kepala Keluarga</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $totalKk }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                Tetap
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Warga</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $totalWarga }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Aktif
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden flex items-center hover:shadow-md transition-shadow">
                    <div class="flex-1 relative z-10">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Menunggu Persetujuan</h4>
                        <div class="flex items-center space-x-3">
                            <p class="text-4xl font-extrabold text-slate-900">{{ $pendingWarga }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                Perlu Aksi
                            </span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center text-amber-600 opacity-60">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

        @else
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ $user->name }}</h3>
                <p class="text-gray-600 mt-1">Gunakan menu di samping untuk mengakses layanan warga.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-gray-500 text-lg">Anda dapat mengajukan surat, melapor, dan melihat pengumuman dari menu navigasi.</p>
            </div>
        @endif

        <!-- Pengumuman Section -->
        <div class="mt-10">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 border-b border-slate-200 pb-3">Pengumuman Terbaru</h3>
            
            @if($pengumumans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pengumumans as $pengumuman)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow duration-300">
                            <div class="p-8 flex-1">
                                <h4 class="text-xl font-bold text-slate-900 mb-3">{{ $pengumuman->judul }}</h4>
                                <div class="flex items-center text-sm text-gray-500 mb-5">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $pengumuman->created_at->format('d M Y') }} 
                                    <span class="mx-2">•</span> 
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $pengumuman->user?->name ?? 'Pengurus' }}
                                </div>
                                <p class="text-gray-700 whitespace-pre-line line-clamp-4 leading-relaxed">{{ $pengumuman->konten }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm p-10 border border-slate-100 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-gray-500 text-lg">Belum ada pengumuman saat ini.</p>
                </div>
            @endif
        </div>
        </div>
    </div>
</x-app-layout>
