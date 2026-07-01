<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiWarga - Sistem Informasi Warga</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-pattern {
            background-image: url('https://i.ibb.co.com/m5tRNWxt/jembatan.jpg');
            background-size: cover;
            background-position: center;
        }
        
        /* Scroll Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased bg-white text-slate-800">

    <div class="w-full bg-white min-h-screen overflow-hidden relative">
        
        <!-- Navigation -->
        <nav class="fixed top-4 left-4 right-4 lg:left-1/2 lg:-translate-x-1/2 lg:w-[95%] lg:max-w-[1200px] flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-lg rounded-full shadow-lg border border-white/50 z-50 transition-all duration-300">
            <a href="/" class="flex items-center gap-3">
                <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="h-14  w-auto">
            </a>
            
            <ul class="hidden md:flex items-center gap-8">
                <li><a href="#" class="text-sm font-semibold text-slate-900 border-b-2 border-slate-900 pb-1">Beranda</a></li>
                <li><a href="#fitur" class="text-sm font-medium text-slate-500 hover:text-amber-500 transition-colors">Fitur Layanan</a></li>
                <li><a href="#pengumuman" class="text-sm font-medium text-slate-500 hover:text-amber-500 transition-colors">Pengumuman</a></li>
                <li><a href="#tentang" class="text-sm font-medium text-slate-500 hover:text-amber-500 transition-colors">Tentang Kami</a></li>
            </ul>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-slate-900 hover:text-amber-500 transition-colors px-4 py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-block text-sm font-bold text-slate-700 hover:text-amber-500 transition-colors px-4 py-2">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold py-2.5 px-6 rounded-full transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-[100vh] w-full hero-pattern group flex items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900/80 flex flex-col justify-center items-center text-center px-6 transition-all duration-700 group-hover:bg-slate-900/70 pt-20">
                <span class="px-4 py-1.5 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold tracking-wider mb-6 backdrop-blur-sm border border-amber-500/30">DIGITALISASI RT & RW</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight leading-tight max-w-4xl drop-shadow-lg">
                    Kelola Lingkungan Warga Lebih <span class="text-amber-400">Mudah & Transparan</span>
                </h1>
                <p class="text-lg text-slate-200 mb-10 max-w-2xl drop-shadow">
                    Sistem Informasi Warga terintegrasi untuk persuratan, pelaporan, dan keuangan lingkungan Anda. Tinggalkan cara lama, beralih ke digital.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full justify-center max-w-md">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex-1 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold py-3.5 px-8 rounded-full transition-all shadow-lg shadow-amber-500/30 flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i> Gabung Sekarang
                        </a>
                    @endif
                    <a href="#fitur" class="flex-1 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-semibold py-3.5 px-8 rounded-full transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-compass"></i> Jelajahi Fitur
                    </a>
                </div>
            </div>
            
            <!-- Floating Stats -->
            <div class="hidden lg:flex absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-white rounded-2xl shadow-xl border border-slate-100 p-6 gap-12 z-10 w-max">
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900">100%</div>
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Transparan</div>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900">24/7</div>
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Layanan</div>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900"><i class="fas fa-bolt text-amber-500"></i></div>
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Cepat & Tepat</div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="tentang" class="pt-24 lg:pt-32 pb-16 px-6 lg:px-16 bg-white">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 fade-in">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold mb-6">
                        <i class="fas fa-info-circle text-amber-500"></i> TENTANG SISTEM
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6 leading-tight">Membangun Ekosistem Warga yang Harmonis & Terhubung</h2>
                    <p class="text-slate-600 text-sm leading-relaxed mb-8">
                        SiWarga hadir sebagai jembatan komunikasi antara pengurus lingkungan (RT/RW) dengan warganya. Kami mengubah proses birokrasi konvensional yang memakan waktu menjadi pengalaman digital yang cepat, aman, dan dapat diakses dari mana saja.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-900 border border-slate-100 shadow-sm">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 mb-1">Administrasi Tanpa Kertas</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Pengajuan surat pengantar domisili, SKTM, dan keterangan lainnya kini bisa dilakukan langsung dari rumah.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-900 border border-slate-100 shadow-sm">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900 mb-1">Informasi Terpusat</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Tidak ada lagi warga yang tertinggal informasi. Setiap pengumuman kegiatan atau rapat akan tersampaikan dengan baik.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Abstract Map/Illustration -->
                <div class="order-1 lg:order-2 h-[400px] rounded-3xl relative overflow-hidden shadow-2xl fade-in" style="background-image: url('https://i.ibb.co.com/8DffTfJw/warga.webp'); background-size: cover; background-position: center;">
                    <!-- Dark Overlay for Readability -->
                    <div class="absolute inset-0 bg-slate-900/50 mix-blend-multiply"></div>
                    
                    <!-- Central Card -->
                    <div class="absolute inset-0 flex items-center justify-center p-8">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 w-full max-w-sm text-center transform hover:scale-105 transition-transform duration-500">
                            <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga" class="h-16 mx-auto mb-4 drop-shadow-md">
                            <h3 class="text-xl font-bold text-white mb-2">Terhubung. Terpadu.</h3>
                            <p class="text-sm text-slate-300">Satu platform untuk semua kebutuhan administrasi dan pelaporan warga tingkat RT dan RW.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Grid (Replaces Attractions) -->
        <section id="fitur" class="py-16 px-6 lg:px-16 bg-slate-50">
            <div class="text-center mb-12 fade-in">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-bold mb-4">
                    <i class="fas fa-layer-group text-slate-900"></i> FITUR UNGGULAN
                </div>
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Layanan Digital dalam Genggaman</h2>
                <p class="text-slate-500 text-sm max-w-2xl mx-auto">Kami merancang berbagai modul untuk mempermudah tugas pengurus dan meningkatkan kenyamanan warga.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group fade-in" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl mb-6 group-hover:bg-amber-500 group-hover:text-slate-900 transition-colors">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Surat Pengantar</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Ajukan berbagai jenis surat pengantar secara online tanpa harus mendatangi rumah RT/RW.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group fade-in" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl mb-6 group-hover:bg-amber-500 group-hover:text-slate-900 transition-colors">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pelaporan Warga</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Laporkan masalah infrastruktur, keamanan, atau kejadian penting dengan bukti foto yang jelas.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group fade-in" style="transition-delay: 300ms;">
                    <div class="w-14 h-14 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl mb-6 group-hover:bg-amber-500 group-hover:text-slate-900 transition-colors">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Transparansi Kas</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Pantau arus uang kas RT/RW, iuran warga, dan pengeluaran secara transparan dan *real-time*.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group fade-in" style="transition-delay: 400ms;">
                    <div class="w-14 h-14 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl mb-6 group-hover:bg-amber-500 group-hover:text-slate-900 transition-colors">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Manajemen Data</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Pengelolaan data demografi warga dan Kartu Keluarga yang terstruktur rapi oleh pengurus.</p>
                </div>
            </div>
        </section>

        <!-- Latest Announcements (Replaces Latest Highlights) -->
        <section id="pengumuman" class="py-16 px-6 lg:px-16 bg-white">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6 fade-in">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold mb-4 border border-amber-200">
                        <i class="fas fa-bell"></i> INFO TERBARU
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900">Pengumuman Terkini</h2>
                    <p class="text-slate-500 text-sm mt-2">Tetap update dengan informasi dan kegiatan di lingkungan kita.</p>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-amber-600 transition-colors">
                        Lihat Semua Info <i class="fas fa-arrow-right"></i>
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($latestPengumumans ?? [] as $pengumuman)
                    @php
                        $bgImage = '';
                        $judulLower = strtolower($pengumuman->judul);
                        if (str_contains($judulLower, 'bantuan') || str_contains($judulLower, 'sembako')) {
                            $bgImage = 'https://i.ibb.co.com/5gh1L3cr/bantuan.webp';
                        } elseif (str_contains($judulLower, 'siskamling') || str_contains($judulLower, 'ronda')) {
                            $bgImage = 'https://i.ibb.co.com/PGttM6R3/Pos-Ronda.jpg';
                        } elseif (str_contains($judulLower, 'rapat') || str_contains($judulLower, 'pleno')) {
                            $bgImage = 'https://i.ibb.co.com/DZBqwqK/rapat.jpg';
                        } else {
                            $bgImage = 'https://i.ibb.co.com/m5tRNWxt/jembatan.jpg';
                        }
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col fade-in">
                        <div class="h-48 relative p-6 flex flex-col justify-between" style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
                            <div class="absolute inset-0 bg-slate-900/40"></div>
                            
                            <span class="relative z-10 self-start bg-amber-500 text-slate-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                Pengumuman
                            </span>
                            <i class="fas fa-bullhorn text-4xl text-white/30 absolute bottom-4 right-4 transform -rotate-12 z-10"></i>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-4 text-[11px] text-slate-400 font-medium mb-3 uppercase tracking-wider">
                                <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt"></i> {{ $pengumuman->created_at->format('d M Y') }}</span>
                                <span class="flex items-center gap-1.5"><i class="far fa-user"></i> {{ $pengumuman->user?->name ?? 'Pengurus' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-3 leading-snug line-clamp-2">{{ $pengumuman->judul }}</h3>
                            <p class="text-sm text-slate-500 line-clamp-3 mb-6 flex-1 leading-relaxed">{{ $pengumuman->konten }}</p>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-900 hover:text-amber-500 inline-flex items-center gap-2 transition-colors mt-auto group">
                                    Baca Selengkapnya <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-900 hover:text-amber-500 inline-flex items-center gap-2 transition-colors mt-auto group">
                                    Masuk untuk membaca <i class="fas fa-sign-in-alt transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                        <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                        <h3 class="text-lg font-bold text-slate-700">Belum ada pengumuman</h3>
                        <p class="text-sm text-slate-500">Saat ini belum ada informasi terbaru dari pengurus.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 px-6 lg:px-16 bg-slate-900 relative overflow-hidden text-center">
            <!-- Decorative Background -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 via-amber-300 to-amber-500"></div>

            <div class="relative z-10 max-w-3xl mx-auto fade-in">
                <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="h-16 w-auto mx-auto mb-8 drop-shadow-lg">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Siap Menuju Lingkungan Digital?</h2>
                <p class="text-slate-300 text-sm md:text-base mb-10 max-w-xl mx-auto leading-relaxed">Bergabunglah dengan SiWarga sekarang. Buat akun baru atau masuk jika Anda sudah terdaftar oleh ketua RT Anda.</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold py-3.5 px-10 rounded-full transition-all shadow-lg hover:-translate-y-1">Daftar Akun Baru</a>
                    @endif
                    <a href="{{ route('login') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold py-3.5 px-10 rounded-full transition-all backdrop-blur-sm hover:-translate-y-1">Masuk ke Sistem</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-950 text-slate-400 py-12 px-6 lg:px-16 text-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10 border-b border-slate-800 pb-10">
                <div class="col-span-1 md:col-span-2">
                    <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga" class="h-8  opacity-70 mb-6">
                    <p class="mb-6 max-w-sm leading-relaxed">Sistem Informasi Warga dirancang untuk memudahkan administrasi kependudukan di tingkat RT dan RW secara transparan, cepat, dan digital.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center hover:bg-amber-500 hover:text-slate-900 hover:border-amber-500 transition-all"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center hover:bg-amber-500 hover:text-slate-900 hover:border-amber-500 transition-all"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center hover:bg-amber-500 hover:text-slate-900 hover:border-amber-500 transition-all"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider text-xs uppercase">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Fitur Utama</a></li>
                        <li><a href="#pengumuman" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Pengumuman</a></li>
                        <li><a href="#tentang" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider text-xs uppercase">Bantuan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Panduan Warga</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px]"></i> Kontak Admin</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
                <p>&copy; {{ date('Y') }} SiWarga. Seluruh hak cipta dilindungi.</p>
                <p class="flex items-center gap-1">Dibuat oleh Tim PANDAWA untuk Warga RW 01 Suak Lanjut</p>
            </div>
        </footer>

    </div>

    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.fade-in').forEach((el) => observer.observe(el));
        });
    </script>
</body>
</html>
