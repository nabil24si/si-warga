<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Portal Warga</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 min-h-screen">

        <!-- Top Navbar -->
        <div class="fixed top-4 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <nav x-data="{ open: false }" class="max-w-7xl mx-auto bg-white/70 backdrop-blur-md border border-white/40 shadow-lg shadow-slate-200/50 rounded-2xl">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center py-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="https://i.ibb.co.com/BKZq1pn1/logosiwarga.png" alt="SiWarga Logo" class="h-20 sm:h-12 w-auto object-contain">
                        </a>
                    </div>

                    <!-- Desktop Nav Links -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-1">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} transition-all duration-200">
                            Beranda
                        </a>
                        <a href="{{ route('surat.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('surat.*') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} transition-all duration-200">
                            Persuratan
                        </a>
                        <a href="{{ route('laporan.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('laporan.*') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} transition-all duration-200">
                            Laporan
                        </a>
                        <a href="{{ route('keuangan.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('keuangan.*') ? 'text-slate-900 bg-slate-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} transition-all duration-200">
                            Kas Keuangan
                        </a>
                    </div>

                    <!-- Settings & Notifications -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        
                        <!-- Notification Bell -->
                        <div x-data="notificationPolling()" x-init="startPolling()" class="relative mr-3 sm:mr-4">
                            <x-dropdown align="right" width="w-80">
                                <x-slot name="trigger">
                                    <button @click="markAsRead()" class="relative p-2.5 text-slate-400 hover:text-slate-900 bg-white/50 hover:bg-white rounded-full border border-slate-200 transition duration-150 ease-in-out focus:outline-none shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        <span x-show="count > 0" x-text="count" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-red-500 rounded-full" style="display: none;"></span>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-4 py-3 border-b border-slate-100 font-bold text-sm text-slate-800">Notifikasi</div>
                                    <div class="max-h-72 overflow-y-auto">
                                        <template x-if="notifications.length === 0">
                                            <div class="px-4 py-6 text-sm text-slate-500 text-center">Belum ada notifikasi.</div>
                                        </template>
                                        <template x-for="notif in notifications" :key="notif.id">
                                            <a :href="notif.url" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-50 transition duration-150">
                                                <p class="text-sm font-semibold text-slate-800" x-text="notif.judul"></p>
                                                <p class="text-xs text-slate-600 mt-1 line-clamp-2" x-text="notif.pesan"></p>
                                                <p class="text-[10px] text-slate-400 mt-1" x-text="notif.created_at"></p>
                                            </a>
                                        </template>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Profile Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-lg text-slate-600 bg-white hover:bg-slate-50 hover:text-slate-900 focus:outline-none transition ease-in-out duration-200">
                                    <div class="w-7 h-7 bg-slate-900 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Mobile Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Mobile Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Beranda</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('surat.index')" :active="request()->routeIs('surat.*')">Persuratan</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">Laporan</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('keuangan.index')" :active="request()->routeIs('keuangan.*')">Kas Keuangan</x-responsive-nav-link>
                </div>
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1 px-4">
                        <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        </div>

        <!-- Page Content -->
        <main class="{{ request()->routeIs('dashboard') ? '' : 'pt-28' }}">
            {{ $slot }}
        </main>

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
