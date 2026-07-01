<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Master Data Warga') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    
                    <!-- Top Actions & Search -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div class="w-full md:w-auto">
                            @if(Auth::user()->role !== 'warga')
                                <a href="{{ route('warga.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + Tambah Data
                                </a>
                            @endif
                        </div>
                        
                        <div class="w-full md:w-auto flex flex-col md:flex-row gap-2">
                            <form action="{{ route('warga.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full">
                                @if(Auth::user()->role === 'rw')
                                    <select name="rt_number" class="border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm w-full md:w-48 text-sm">
                                        <option value="">Semua RT</option>
                                        <option value="01" {{ request('rt_number') == '01' ? 'selected' : '' }}>RT 01</option>
                                        <option value="02" {{ request('rt_number') == '02' ? 'selected' : '' }}>RT 02</option>
                                        <option value="03" {{ request('rt_number') == '03' ? 'selected' : '' }}>RT 03</option>
                                    </select>
                                @endif
                                
                                <div class="flex">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK..." class="border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-l-md shadow-sm w-full md:w-64 text-sm">
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-slate-100 border border-l-0 border-gray-300 rounded-r-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:ring-offset-2 text-sm font-medium">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK / No KK</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">L/P</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RT</th>
                                    @if(Auth::user()->role !== 'warga')
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($wargas as $warga)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $warga->nik }}</div>
                                            <div class="text-xs text-gray-500">KK: {{ $warga->no_kk }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $warga->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500">{{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $warga->jenis_kelamin }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            RT {{ $warga->rt_number }}
                                        </td>
                                        
                                        @if(Auth::user()->role !== 'warga')
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('warga.edit', $warga->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Edit
                                                    </a>
                                                    
                                                    <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role !== 'warga' ? '5' : '4' }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada data warga yang sesuai.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $wargas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
