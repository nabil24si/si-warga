<x-dynamic-component :component="Auth::user()->role === 'warga' ? 'warga-layout' : 'app-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Buat Laporan / Keluhan') }}
        </h2>
    </x-slot>

    <div class="{{ Auth::user()->role === 'warga' ? 'max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8' : 'py-6 max-w-7xl mx-auto sm:px-6 lg:px-8' }}">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            
                            <div>
                                <x-input-label for="judul" :value="__('Judul Laporan')" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus placeholder="Contoh: Lampu Jalan Mati di RT 01" />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                                <textarea id="deskripsi" name="deskripsi" rows="5" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required placeholder="Jelaskan detail laporan atau keluhan Anda di sini...">{{ old('deskripsi') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>

                            <div x-data="{ 
                                imagePreview: null, 
                                fileName: '',
                                handleFileChange(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        this.fileName = file.name;
                                        this.imagePreview = URL.createObjectURL(file);
                                    } else {
                                        this.clearPreview();
                                    }
                                },
                                clearPreview() {
                                    this.imagePreview = null;
                                    this.fileName = '';
                                    this.$refs.fileInput.value = '';
                                }
                            }">
                                <x-input-label for="foto_lampiran" :value="__('Foto Lampiran (Opsional)')" />
                                
                                <!-- Upload Area -->
                                <div x-show="!imagePreview" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-500 transition-colors bg-gray-50 relative">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="relative cursor-pointer bg-transparent rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                Upload a file
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, JPEG up to 2MB
                                        </p>
                                    </div>
                                    <input x-ref="fileInput" @change="handleFileChange" type="file" id="foto_lampiran" name="foto_lampiran" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/jpeg,image/png,image/jpg">
                                </div>
                                
                                <!-- Preview Area -->
                                <div x-show="imagePreview" class="mt-1 border-2 border-gray-200 rounded-md p-4 bg-gray-50 flex flex-col items-center relative" style="display: none;">
                                    <img :src="imagePreview" alt="Preview" class="max-h-64 object-contain rounded mb-4 shadow-sm border border-gray-200">
                                    <p class="text-sm text-gray-600 mb-3" x-text="fileName"></p>
                                    <div class="flex space-x-3 w-full justify-center">
                                        <button type="button" @click="$refs.fileInput.click()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                            Ganti Foto
                                        </button>
                                        <button type="button" @click="clearPreview()" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none transition ease-in-out duration-150">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                                
                                <x-input-error :messages="$errors->get('foto_lampiran')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 transition ease-in-out duration-150">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
