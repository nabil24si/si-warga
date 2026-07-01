<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-6">
                        <div class="max-w-xl">
                            <h3 class="text-2xl font-bold text-slate-900 break-words">{{ $laporan->judul }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Dilaporkan pada {{ $laporan->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            @if($laporan->status === 'menunggu')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                            @elseif($laporan->status === 'diproses')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                            @elseif($laporan->status === 'selesai')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Deskripsi Laporan</h4>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $laporan->deskripsi }}</p>
                                </div>
                            </div>

                            @if($laporan->foto_lampiran)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Foto Lampiran</h4>
                                    <div class="border rounded-lg overflow-hidden max-w-md">
                                        <img src="{{ Storage::url($laporan->foto_lampiran) }}" alt="Lampiran Laporan" class="w-full h-auto object-cover">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Data Pelapor & Aksi -->
                        <div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-6">
                                <h4 class="text-lg font-semibold text-slate-800 mb-3 border-b pb-2">Informasi Pelapor</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="block text-xs font-medium text-gray-500">Nama</span>
                                        <span class="block text-sm text-gray-900 font-medium">{{ $laporan->user->name }}</span>
                                    </div>
                                    @if($laporan->user->warga)
                                    <div>
                                        <span class="block text-xs font-medium text-gray-500">RT</span>
                                        <span class="block text-sm text-gray-900 font-medium">RT {{ $laporan->user->warga->rt_number }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-medium text-gray-500">Kontak</span>
                                        <span class="block text-sm text-gray-900 font-medium">{{ $laporan->user->phone_number ?? '-' }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if(Auth::user()->role !== 'warga')
                                <div class="bg-white p-4 rounded-xl border shadow-sm">
                                    <h4 class="text-sm font-semibold text-slate-800 mb-3 border-b pb-2">Ubah Status Laporan</h4>
                                    <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        
                                        <div>
                                            <select name="status" class="block w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm text-sm">
                                                <option value="menunggu" {{ $laporan->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diproses" {{ $laporan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                        
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t">
                        <a href="{{ route('laporan.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            &larr; Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
