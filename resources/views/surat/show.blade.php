<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Detail Surat') }}
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
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ $surat->jenis_surat }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Diajukan pada {{ $surat->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            @if($surat->status === 'menunggu_rt')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu RT</span>
                            @elseif($surat->status === 'menunggu_rw')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu RW</span>
                            @elseif($surat->status === 'selesai')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Data Pemohon -->
                        <div>
                            <h4 class="text-lg font-semibold text-slate-800 mb-3">Data Pemohon</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Nama Lengkap</span>
                                    <span class="block text-base text-gray-900">{{ $surat->user->name }}</span>
                                </div>
                                @if($surat->user->warga)
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">NIK / No. KK</span>
                                    <span class="block text-base text-gray-900">{{ $surat->user->warga->nik }} / {{ $surat->user->warga->no_kk }}</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">RT</span>
                                    <span class="block text-base text-gray-900">RT {{ $surat->user->warga->rt_number }}</span>
                                </div>
                                @endif
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Keperluan</span>
                                    <span class="block text-base text-gray-900">{{ $surat->keperluan }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Tambahan -->
                        <div>
                            @if($surat->data_tambahan)
                                <h4 class="text-lg font-semibold text-slate-800 mb-3">Data Tambahan</h4>
                                <div class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    @foreach($surat->data_tambahan as $key => $value)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="block text-base text-gray-900">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($surat->status === 'ditolak')
                        <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                            <h4 class="text-sm font-semibold text-red-800 uppercase tracking-wider mb-1">Alasan Penolakan</h4>
                            <p class="text-red-900">{{ $surat->keterangan_penolakan }}</p>
                        </div>
                    @endif

                    <div class="mt-8 pt-6 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                        <a href="{{ route('surat.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            &larr; Kembali ke Daftar
                        </a>

                        <div class="flex space-x-3" x-data="{ showTolakModal: false }">
                            
                            @if($surat->status === 'selesai')
                                <a href="{{ route('surat.cetakPdf', $surat->id) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                    Cetak PDF
                                </a>
                            @endif

                            @if(
                                (Auth::user()->role === 'rt' && $surat->status === 'menunggu_rt') || 
                                (Auth::user()->role === 'rw' && $surat->status === 'menunggu_rw')
                            )
                                <button type="button" @click="showTolakModal = true" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 transition ease-in-out duration-150">
                                    Tolak
                                </button>

                                <form action="{{ route('surat.updateStatus', $surat->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui surat ini?');">
                                    @csrf
                                    <input type="hidden" name="status" value="setujui">
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 transition ease-in-out duration-150">
                                        Setujui
                                    </button>
                                </form>
                            @endif

                            <!-- Modal Penolakan (Alpine.js) -->
                            <div x-show="showTolakModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    
                                    <div x-show="showTolakModal" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                    </div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div x-show="showTolakModal" x-transition class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <form action="{{ route('surat.updateStatus', $surat->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="tolak">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ms-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                                            Alasan Penolakan
                                                        </h3>
                                                        <div class="mt-4">
                                                            <textarea name="keterangan_penolakan" rows="3" class="block w-full border-gray-300 focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 rounded-md shadow-sm" required placeholder="Tulis alasan mengapa surat ditolak..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ms-3 sm:w-auto sm:text-sm">
                                                    Tolak Surat
                                                </button>
                                                <button type="button" @click="showTolakModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ms-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
