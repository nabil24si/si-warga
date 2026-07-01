<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('pengumuman.update', $pengumuman->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="judul" :value="__('Judul Pengumuman')" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul', $pengumuman->judul)" required autofocus />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="konten" :value="__('Isi Pengumuman')" />
                                <textarea id="konten" name="konten" rows="6" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring focus:ring-blue-900 focus:ring-opacity-50 rounded-md shadow-sm" required>{{ old('konten', $pengumuman->konten) }}</textarea>
                                <x-input-error :messages="$errors->get('konten')" class="mt-2" />
                            </div>

                            <div class="block">
                                <label for="is_active" class="inline-flex items-center">
                                    <input id="is_active" type="checkbox" class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-blue-900" name="is_active" value="1" {{ old('is_active', $pengumuman->is_active) ? 'checked' : '' }}>
                                    <span class="ms-2 text-sm text-gray-600">{{ __('Tampilkan/Aktif') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-3">
                            <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
