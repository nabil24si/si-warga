<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Akun RT</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar ketua RT dan hak akses mereka.</p>
            </div>
            <a href="{{ route('rt-management.create') }}" class="bg-slate-900 hover:bg-slate-800 text-white rounded-xl py-2 px-4 font-bold text-sm shadow-sm transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Akun RT
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center shadow-sm" role="alert">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-slate-50 rounded-2xl p-4 sm:p-6 border border-slate-100">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50/50 border-b border-slate-100 text-slate-900">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Ketua RT</th>
                                <th scope="col" class="px-6 py-4 font-bold">Email</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Nomor RT</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($rtUsers as $user)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block bg-slate-100 text-slate-800 font-extrabold px-3 py-1 rounded-full text-xs">
                                            RT {{ $user->rt_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->status_akun === 'aktif')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100 uppercase tracking-wider">
                                                {{ $user->status_akun }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('rt-management.edit', $user) }}" class="bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg px-3 py-1.5 font-bold transition-colors shadow-sm text-xs">
                                                Edit
                                            </a>
                                            <form action="{{ route('rt-management.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun RT ini? (Akses login akan dicabut namun data riwayat akan tetap aman)');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg px-3 py-1.5 font-bold transition-colors shadow-sm text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <p class="font-bold">Belum ada akun RT.</p>
                                            <p class="text-sm mt-1 text-slate-400 font-medium">Klik tombol tambah di atas untuk membuat akun baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
