<x-dynamic-component :component="Auth::user()->role === 'warga' ? 'warga-layout' : 'app-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Ajukan Surat') }}
        </h2>
    </x-slot>

    <div class="{{ Auth::user()->role === 'warga' ? 'max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8' : 'py-6 max-w-7xl mx-auto sm:px-6 lg:px-8' }}">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('surat.store') }}" x-data="{ jenis_surat: '{{ old('jenis_surat', '') }}' }">
                        @csrf
                        
                        <div class="space-y-6">
                            
                            <!-- Jenis Surat -->
                            <div>
                                <x-input-label for="jenis_surat" :value="__('Jenis Surat')" />
                                <select id="jenis_surat" name="jenis_surat" x-model="jenis_surat" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    <option value="Pengantar SKCK">Pengantar SKCK</option>
                                    <option value="Keterangan Pindah">Keterangan Pindah</option>
                                    <option value="Keterangan Usaha">Keterangan Usaha</option>
                                    <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                    <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                                    <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                                    <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                                    <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                                    <option value="Lainnya (Tulis Sendiri)">Lainnya (Tulis Sendiri)</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_surat')" class="mt-2" />
                            </div>

                            <!-- Jenis Surat Lainnya -->
                            <div x-show="jenis_surat === 'Lainnya (Tulis Sendiri)'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="jenis_surat_lainnya" :value="__('Nama/Jenis Surat')" />
                                    <x-text-input id="jenis_surat_lainnya" class="block mt-1 w-full" type="text" name="jenis_surat_lainnya" :value="old('jenis_surat_lainnya')" x-bind:required="jenis_surat === 'Lainnya (Tulis Sendiri)'" placeholder="Tuliskan jenis surat yang Anda perlukan..." />
                                    <x-input-error :messages="$errors->get('jenis_surat_lainnya')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div>
                                <x-input-label for="keperluan" :value="__('Keperluan')" />
                                <textarea id="keperluan" name="keperluan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required>{{ old('keperluan') }}</textarea>
                                <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
                            </div>

                            <!-- Dinamis: Keterangan Pindah -->
                            <div x-show="jenis_surat === 'Keterangan Pindah'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="alamat_asal" :value="__('Alamat Asal')" />
                                    <textarea id="alamat_asal" name="alamat_asal" rows="2" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" x-bind:required="jenis_surat === 'Keterangan Pindah'">{{ old('alamat_asal') }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat_asal')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="alamat_tujuan" :value="__('Alamat Tujuan')" />
                                    <textarea id="alamat_tujuan" name="alamat_tujuan" rows="2" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" x-bind:required="jenis_surat === 'Keterangan Pindah'">{{ old('alamat_tujuan') }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat_tujuan')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Keterangan Usaha -->
                            <div x-show="jenis_surat === 'Keterangan Usaha'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="nama_usaha" :value="__('Nama Usaha')" />
                                    <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha" :value="old('nama_usaha')" x-bind:required="jenis_surat === 'Keterangan Usaha'" />
                                    <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="bidang_usaha" :value="__('Bidang Usaha')" />
                                    <x-text-input id="bidang_usaha" class="block mt-1 w-full" type="text" name="bidang_usaha" :value="old('bidang_usaha')" x-bind:required="jenis_surat === 'Keterangan Usaha'" />
                                    <x-input-error :messages="$errors->get('bidang_usaha')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Surat Keterangan Domisili -->
                            <div x-show="jenis_surat === 'Surat Keterangan Domisili'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="lama_tinggal" :value="__('Lama Tinggal')" />
                                    <x-text-input id="lama_tinggal" class="block mt-1 w-full" type="text" name="lama_tinggal" :value="old('lama_tinggal')" x-bind:required="jenis_surat === 'Surat Keterangan Domisili'" placeholder="Misal: 2 Tahun" />
                                    <x-input-error :messages="$errors->get('lama_tinggal')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="alamat_sebelumnya" :value="__('Alamat Sebelumnya')" />
                                    <textarea id="alamat_sebelumnya" name="alamat_sebelumnya" rows="2" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" x-bind:required="jenis_surat === 'Surat Keterangan Domisili'">{{ old('alamat_sebelumnya') }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat_sebelumnya')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Surat Keterangan Tidak Mampu (SKTM) -->
                            <div x-show="jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="tujuan_penggunaan" :value="__('Tujuan Penggunaan')" />
                                    <x-text-input id="tujuan_penggunaan" class="block mt-1 w-full" type="text" name="tujuan_penggunaan" :value="old('tujuan_penggunaan')" x-bind:required="jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)'" placeholder="Misal: Beasiswa, Keringanan Biaya RS" />
                                    <x-input-error :messages="$errors->get('tujuan_penggunaan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="pekerjaan_kepala_keluarga" :value="__('Pekerjaan Kepala Keluarga')" />
                                    <x-text-input id="pekerjaan_kepala_keluarga" class="block mt-1 w-full" type="text" name="pekerjaan_kepala_keluarga" :value="old('pekerjaan_kepala_keluarga')" x-bind:required="jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)'" />
                                    <x-input-error :messages="$errors->get('pekerjaan_kepala_keluarga')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Surat Keterangan Kematian -->
                            <div x-show="jenis_surat === 'Surat Keterangan Kematian'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="nama_almarhum" :value="__('Nama Almarhum/Almarhumah')" />
                                    <x-text-input id="nama_almarhum" class="block mt-1 w-full" type="text" name="nama_almarhum" :value="old('nama_almarhum')" x-bind:required="jenis_surat === 'Surat Keterangan Kematian'" />
                                    <x-input-error :messages="$errors->get('nama_almarhum')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_meninggal" :value="__('Tanggal Meninggal')" />
                                    <x-text-input id="tanggal_meninggal" class="block mt-1 w-full" type="date" name="tanggal_meninggal" :value="old('tanggal_meninggal')" x-bind:required="jenis_surat === 'Surat Keterangan Kematian'" />
                                    <x-input-error :messages="$errors->get('tanggal_meninggal')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="tempat_meninggal" :value="__('Tempat Meninggal')" />
                                    <x-text-input id="tempat_meninggal" class="block mt-1 w-full" type="text" name="tempat_meninggal" :value="old('tempat_meninggal')" x-bind:required="jenis_surat === 'Surat Keterangan Kematian'" />
                                    <x-input-error :messages="$errors->get('tempat_meninggal')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Surat Keterangan Kelahiran -->
                            <div x-show="jenis_surat === 'Surat Keterangan Kelahiran'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="nama_anak" :value="__('Nama Anak')" />
                                    <x-text-input id="nama_anak" class="block mt-1 w-full" type="text" name="nama_anak" :value="old('nama_anak')" x-bind:required="jenis_surat === 'Surat Keterangan Kelahiran'" />
                                    <x-input-error :messages="$errors->get('nama_anak')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="nama_ayah" :value="__('Nama Ayah')" />
                                    <x-text-input id="nama_ayah" class="block mt-1 w-full" type="text" name="nama_ayah" :value="old('nama_ayah')" x-bind:required="jenis_surat === 'Surat Keterangan Kelahiran'" />
                                    <x-input-error :messages="$errors->get('nama_ayah')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="nama_ibu" :value="__('Nama Ibu')" />
                                    <x-text-input id="nama_ibu" class="block mt-1 w-full" type="text" name="nama_ibu" :value="old('nama_ibu')" x-bind:required="jenis_surat === 'Surat Keterangan Kelahiran'" />
                                    <x-input-error :messages="$errors->get('nama_ibu')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Dinamis: Surat Keterangan Belum Menikah -->
                            <div x-show="jenis_surat === 'Surat Keterangan Belum Menikah'" x-transition class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4" style="display: none;">
                                <div>
                                    <x-input-label for="tujuan_penggunaan_belum_menikah" :value="__('Tujuan Penggunaan')" />
                                    <x-text-input id="tujuan_penggunaan_belum_menikah" class="block mt-1 w-full" type="text" name="tujuan_penggunaan_belum_menikah" :value="old('tujuan_penggunaan_belum_menikah')" x-bind:required="jenis_surat === 'Surat Keterangan Belum Menikah'" />
                                    <x-input-error :messages="$errors->get('tujuan_penggunaan_belum_menikah')" class="mt-2" />
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('surat.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
