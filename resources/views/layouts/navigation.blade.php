<nav x-data="{ open: false }" class="bg-white border-b border-slate-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Left Side Empty (Content in Sidebar) -->
            </div>

            <!-- Settings & Notifications -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                <!-- Notification Bell -->
                <div x-data="notificationPolling()" x-init="startPolling()" class="relative mr-4 sm:mr-5">
                    <x-dropdown align="right" width="w-80">
                        <x-slot name="trigger">
                            <button @click="markAsRead()" class="relative p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-full transition duration-150 ease-in-out focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
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

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-xl text-slate-600 bg-white hover:bg-slate-50 hover:text-slate-900 focus:outline-none transition ease-in-out duration-200 shadow-sm">
                            <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center mr-2 shadow-inner">
                                <span class="text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="text-left flex flex-col items-start mr-2">
                                <span class="font-semibold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold leading-tight">{{ Auth::user()->role }}</span>
                            </div>

                            <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
