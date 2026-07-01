<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center">
            <a href="{{ route('rt-management.index') }}" class="text-slate-500 hover:text-slate-900 mr-4 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Akun RT</h1>
                <p class="text-sm text-slate-500 mt-1">Perbarui data atau reset password ketua RT.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <form action="{{ route('rt-management.update', $user) }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap Ketua RT</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm placeholder-slate-400 shadow-sm transition duration-200">
                    @error('name')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm placeholder-slate-400 shadow-sm transition duration-200">
                    @error('email')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rt_number" class="block text-sm font-bold text-slate-700 mb-1.5">Nomor RT</label>
                    <select name="rt_number" id="rt_number" required
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm shadow-sm transition duration-200 font-medium">
                        <option value="" disabled>Pilih Nomor RT</option>
                        @for ($i = 1; $i <= 15; $i++)
                            @php $rtStr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                            <option value="{{ $rtStr }}" {{ old('rt_number', $user->rt_number) == $rtStr ? 'selected' : '' }}>RT {{ $rtStr }}</option>
                        @endfor
                    </select>
                    @error('rt_number')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Reset Password (Opsional)</label>
                    <input type="password" name="password" id="password"
                        class="block w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 sm:text-sm placeholder-slate-400 shadow-sm transition duration-200"
                        placeholder="Biarkan kosong jika tidak ingin mengubah password">
                    @error('password')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs font-medium text-slate-500">Hanya isi bagian ini jika Anda ingin menyetel ulang kata sandi pengguna.</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <a href="{{ route('rt-management.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl px-5 py-2.5 font-bold transition-colors shadow-sm text-sm mr-3">
                        Batal
                    </a>
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white rounded-xl px-6 py-2.5 font-bold transition-colors shadow-sm text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
