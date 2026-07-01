<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Persetujuan Akun</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar warga yang menunggu persetujuan akun.</p>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center" role="alert">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-900">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Email</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Tanggal Daftar</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pendingUsers as $user)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('approval.approve', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white rounded-lg px-4 py-2 font-medium transition-colors shadow-sm text-xs">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('approval.reject', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak dan menghapus data pendaftar ini secara permanen?');">
                                            @csrf
                                            <button type="submit" class="bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg px-4 py-2 font-medium transition-colors shadow-sm text-xs">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="font-medium">Tidak ada pendaftar baru.</p>
                                        <p class="text-sm mt-1 text-slate-400">Semua pendaftaran warga telah diproses.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
