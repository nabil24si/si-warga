<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-slate-50 overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-slate-200 flex flex-col hidden sm:flex">
                <div class="flex items-center justify-center px-4 h-24 border-b border-slate-100">
                    <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="w-48 h-auto object-contain">
                </div>
                
                <div class="px-6 py-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Menu Utama</p>
                    <nav class="space-y-1.5">
                        @php
                            $activeClass = 'bg-slate-900 text-white font-semibold rounded-xl shadow-sm';
                            $inactiveClass = 'text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-all duration-200 rounded-xl font-medium';
                        @endphp

                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('warga.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('warga.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Data Warga
                        </a>
                        
                        @if(Auth::user()->role !== 'warga')
                        <a href="{{ route('pengumuman.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('pengumuman.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Pengumuman
                        </a>
                        @endif
                        
                        <a href="{{ route('surat.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('surat.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Persuratan
                        </a>
                        
                        <a href="{{ route('laporan.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('laporan.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Laporan Warga
                        </a>
                        
                        <a href="{{ route('keuangan.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('keuangan.*') ? $activeClass : $inactiveClass }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kas Keuangan
                        </a>
                        @if(Auth::user()->role === 'rw' || Auth::user()->role === 'admin')
                            <a href="{{ route('rt-management.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('rt-management.*') ? $activeClass : $inactiveClass }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Manajemen RT
                            </a>
                        @endif
                        @if(Auth::user()->role === 'rt' || Auth::user()->role === 'rw' || Auth::user()->role === 'admin')
                            <a href="{{ route('approval.index') }}" class="flex items-center px-4 py-2.5 {{ request()->routeIs('approval.*') ? $activeClass : $inactiveClass }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Persetujuan Akun
                                @php
                                    $pendingCount = \App\Models\User::where('role', 'warga')->where('status_akun', 'pending')->count();
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="ml-auto bg-rose-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        @endif
                    </nav>
                </div>
            </aside>

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Navbar -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm z-10">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <script>
            function notificationPolling() {
                return {
                    count: 0,
                    notifications: [],
                    startPolling() {
                        this.fetchUnread();
                        setInterval(() => this.fetchUnread(), 15000);
                    },
                    fetchUnread() {
                        fetch('{{ route("notifications.unread") }}')
                            .then(response => response.json())
                            .then(data => {
                                this.count = data.count;
                                this.notifications = data.notifications;
                            })
                            .catch(error => console.error('Error fetching notifications:', error));
                    },
                    markAsRead() {
                        if (this.count > 0) {
                            fetch('{{ route("notifications.markAsRead") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                }
                            }).then(() => {
                                this.count = 0;
                            });
                        }
                    }
                }
            }
        </script>
    </body>
</html>
