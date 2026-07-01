<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Warga') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('warga.update', $warga->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <x-input-label for="nik" :value="__('NIK')" />
                                <x-text-input id="nik" class="block mt-1 w-full bg-gray-100" type="text" name="nik" :value="old('nik', $warga->nik)" required maxlength="16" readonly />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="no_kk" :value="__('No KK')" />
                                <x-text-input id="no_kk" class="block mt-1 w-full" type="text" name="no_kk" :value="old('no_kk', $warga->no_kk)" required maxlength="16" />
                                <x-input-error :messages="$errors->get('no_kk')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $warga->nama_lengkap)" required />
                                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $warga->tempat_lahir)" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $warga->tanggal_lahir)" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="agama" :value="__('Agama')" />
                                <x-text-input id="agama" class="block mt-1 w-full" type="text" name="agama" :value="old('agama', $warga->agama)" required />
                                <x-input-error :messages="$errors->get('agama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                                <x-text-input id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" :value="old('pekerjaan', $warga->pekerjaan)" required />
                                <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" />
                                <select id="status_perkawinan" name="status_perkawinan" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
                            </div>

                            @if(Auth::user()->role === 'rw')
                            <div>
                                <x-input-label for="rt_number" :value="__('RT (01, 02, dst)')" />
                                <x-text-input id="rt_number" class="block mt-1 w-full" type="text" name="rt_number" :value="old('rt_number', $warga->rt_number)" required />
                                <x-input-error :messages="$errors->get('rt_number')" class="mt-2" />
                            </div>
                            @endif

                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('warga.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
