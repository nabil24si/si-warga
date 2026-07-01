<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Warga::query();

        // Efficient query filtering based on role
        if ($user->role === 'rt') {
            $query->where('rt_number', $user->rt_number);
        } elseif ($user->role === 'warga') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'rw' && $request->filled('rt_number')) {
            $query->where('rt_number', $request->rt_number);
        }

        // Search by nama_lengkap or nik
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $wargas = $query->latest()->paginate(10);

        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:wargas',
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'rt_number' => $user->role === 'rt' ? 'nullable' : 'required|string',
        ]);

        if ($user->role === 'rt') {
            $validated['rt_number'] = $user->rt_number;
        }

        Warga::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga)
    {
        $user = Auth::user();
        if ($user->role === 'warga' || ($user->role === 'rt' && $warga->rt_number !== $user->rt_number)) {
            abort(403, 'Unauthorized action.');
        }

        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $user = Auth::user();
        if ($user->role === 'warga' || ($user->role === 'rt' && $warga->rt_number !== $user->rt_number)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:wargas,nik,' . $warga->id,
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'rt_number' => $user->role === 'rt' ? 'nullable' : 'required|string',
        ]);

        if ($user->role === 'rt') {
            $validated['rt_number'] = $user->rt_number;
        }

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $user = Auth::user();
        if ($user->role === 'warga' || ($user->role === 'rt' && $warga->rt_number !== $user->rt_number)) {
            abort(403, 'Unauthorized action.');
        }

        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil dihapus.');
    }
}
