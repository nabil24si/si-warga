<x-warga-layout>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative bg-slate-900 overflow-hidden min-h-[400px]">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://i.ibb.co.com/zVsZF6sm/pekanbaru-siak-sri-indrapura-1-1k6w3.jpg" alt="Pekanbaru Siak" class="w-full h-full object-cover opacity-40">
        </div>
        <!-- Gradient overlay -->
        <div class="absolute inset-0 z-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 sm:pb-20">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-semibold uppercase tracking-wider mb-2">Portal Warga</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                        Selamat Datang, {{ $user->name }}! 👋
                    </h1>
                    <p class="mt-3 text-slate-300 text-lg max-w-xl">
                        Akses layanan persuratan, pelaporan, dan informasi terkini dari pengurus RT/RW Anda langsung dari sini.
                    </p>
                </div>
                <div class="mt-6 sm:mt-0 flex-shrink-0">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                        <span class="text-4xl font-extrabold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Ajukan Surat -->
            <a href="{{ route('surat.create') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 block">
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-blue-100 transition-colors duration-300">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Ajukan Surat</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Buat pengajuan surat pengantar, domisili, SKTM, dan lainnya secara online.</p>
            </a>

            <!-- Buat Laporan -->
            <a href="{{ route('laporan.create') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 block">
                <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-amber-100 transition-colors duration-300">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Buat Laporan</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Laporkan keluhan, kerusakan fasilitas, atau masalah lingkungan di sekitar Anda.</p>
            </a>

            <!-- Lihat Keuangan -->
            <a href="{{ route('keuangan.index') }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 block">
                <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-emerald-100 transition-colors duration-300">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Transparansi Keuangan</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Lihat rekapitulasi arus kas dan iuran warga secara transparan.</p>
            </a>

        </div>
    </section>

    <!-- Riwayat Aktif -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Riwayat Surat -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Pengajuan Surat Terakhir</h3>
                    <a href="{{ route('surat.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">Lihat Semua →</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($suratTerbaru as $surat)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $surat->jenis_surat }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $surat->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @switch($surat->status)
                                    @case('menunggu_rt')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">Menunggu RT</span>
                                        @break
                                    @case('menunggu_rw')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Menunggu RW</span>
                                        @break
                                    @case('selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>
                                        @break
                                    @case('ditolak')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">Ditolak</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-sm text-slate-400">Belum ada pengajuan surat.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Riwayat Laporan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900">Laporan Terakhir</h3>
                    <a href="{{ route('laporan.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">Lihat Semua →</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($laporanTerbaru as $laporan)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $laporan->judul }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $laporan->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @switch($laporan->status)
                                    @case('pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">Pending</span>
                                        @break
                                    @case('diproses')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Diproses</span>
                                        @break
                                    @case('selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <p class="text-sm text-slate-400">Belum ada laporan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- Pengumuman Terbaru -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-slate-900">Pengumuman Terbaru</h3>
        </div>

        @if($pengumumans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pengumumans as $pengumuman)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="p-7">
                            <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $pengumuman->judul }}</h4>
                            <div class="flex items-center text-xs text-slate-400 mb-4">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $pengumuman->created_at->format('d M Y') }}
                                <span class="mx-1.5">•</span>
                                {{ $pengumuman->user->name }}
                            </div>
                            <p class="text-sm text-slate-600 whitespace-pre-line line-clamp-3 leading-relaxed">{{ $pengumuman->konten }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm p-10 border border-slate-100 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <p class="text-slate-400">Belum ada pengumuman saat ini.</p>
            </div>
        @endif
    </section>

</x-warga-layout>
