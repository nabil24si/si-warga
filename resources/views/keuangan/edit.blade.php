<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Transaksi Kas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('keuangan.update', $keuangan->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            
                            <!-- Jenis Transaksi -->
                            <div>
                                <x-input-label for="jenis_transaksi" :value="__('Jenis Transaksi')" />
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio text-slate-900 border-gray-300 focus:ring-slate-900" name="jenis_transaksi" value="pemasukan" {{ (old('jenis_transaksi', $keuangan->jenis_transaksi) === 'pemasukan') ? 'checked' : '' }} required>
                                        <span class="ml-2 text-gray-700">Pemasukan</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" class="form-radio text-slate-900 border-gray-300 focus:ring-slate-900" name="jenis_transaksi" value="pengeluaran" {{ (old('jenis_transaksi', $keuangan->jenis_transaksi) === 'pengeluaran') ? 'checked' : '' }} required>
                                        <span class="ml-2 text-gray-700">Pengeluaran</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('jenis_transaksi')" class="mt-2" />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori / Keperluan')" />
                                <x-text-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" :value="old('kategori', $keuangan->kategori)" required />
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>

                            <!-- Nominal -->
                            <div>
                                <x-input-label for="nominal" :value="__('Nominal (Rp)')" />
                                <x-text-input id="nominal" class="block mt-1 w-full" type="number" min="0" step="1" name="nominal" :value="old('nominal', (int)$keuangan->nominal)" required />
                                <x-input-error :messages="$errors->get('nominal')" class="mt-2" />
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal_transaksi" :value="__('Tanggal Transaksi')" />
                                <x-text-input id="tanggal_transaksi" class="block mt-1 w-full" type="date" name="tanggal_transaksi" :value="old('tanggal_transaksi', $keuangan->tanggal_transaksi->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_transaksi')" class="mt-2" />
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan Tambahan (Opsional)')" />
                                <textarea id="keterangan" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('keuangan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
