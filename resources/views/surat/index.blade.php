<x-dynamic-component :component="Auth::user()->role === 'warga' ? 'warga-layout' : 'app-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Persuratan Warga') }}
        </h2>
    </x-slot>

    <div class="{{ Auth::user()->role === 'warga' ? 'max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8' : 'py-6 max-w-7xl mx-auto sm:px-6 lg:px-8' }}">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-900">Daftar Pengajuan Surat</h3>
                        @if(Auth::user()->role === 'warga')
                            <a href="{{ route('surat.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                + Ajukan Surat
                            </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Pengajuan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($surats as $surat)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $surat->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $surat->user->name }}</div>
                                            @if($surat->user->warga)
                                                <div class="text-xs text-gray-500">RT {{ $surat->user->warga->rt_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $surat->jenis_surat }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($surat->status === 'menunggu_rt')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu RT</span>
                                            @elseif($surat->status === 'menunggu_rw')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu RW</span>
                                            @elseif($surat->status === 'selesai')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada data pengajuan surat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $surats->links() }}
                    </div>
                </div>
            </div>
        </div>
</x-dynamic-component>
