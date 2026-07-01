<x-dynamic-component :component="Auth::user()->role === 'warga' ? 'warga-layout' : 'app-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Transparansi Kas Keuangan') }}
        </h2>
    </x-slot>

    <div class="{{ Auth::user()->role === 'warga' ? 'max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8' : 'py-6 max-w-7xl mx-auto sm:px-6 lg:px-8' }}">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Saldo Akhir</h4>
                    <p class="mt-2 text-3xl font-bold text-slate-900">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Pemasukan Bulan Ini</h4>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Pengeluaran Bulan Ini</h4>
                    <p class="mt-2 text-3xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Main Panel -->
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
                    
                    <!-- Filter -->
                    <form method="GET" action="{{ route('keuangan.index') }}" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <select name="bulan" class="rounded-md border-gray-300 shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="tahun" class="rounded-md border-gray-300 shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200">
                            @foreach(range(date('Y') - 5, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest hover:bg-slate-200 active:bg-slate-300 transition">
                            Filter
                        </button>

                        <a href="{{ route('keuangan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-slate-900 rounded-md font-semibold text-xs text-slate-900 uppercase tracking-widest hover:bg-slate-900 hover:text-white transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Cetak Laporan PDF
                        </a>
                    </form>

                    <!-- Tambah Data -->
                    @if(Auth::user()->role !== 'warga')
                    <div>
                        <a href="{{ route('keuangan.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition">
                            + Tambah Transaksi
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                @if(Auth::user()->role !== 'warga')
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transaksis as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $t->tanggal_transaksi->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $t->kategori }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $t->keterangan ?: '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right">
                                    @if($t->jenis_transaksi === 'pemasukan')
                                        <span class="text-emerald-600">+ Rp {{ number_format($t->nominal, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-red-600">- Rp {{ number_format($t->nominal, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                
                                @if(Auth::user()->role !== 'warga')
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('keuangan.edit', $t->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('keuangan.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role !== 'warga' ? '5' : '4' }}" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada transaksi pada periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
</x-dynamic-component>
