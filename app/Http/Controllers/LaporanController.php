<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Laporan::with('user');

        if ($user->role === 'warga') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'rt') {
            $query->whereHas('user.warga', function($q) use ($user) {
                $q->where('rt_number', $user->rt_number);
            });
        }

        $laporans = $query->latest()->paginate(10);
        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'warga') {
            return redirect()->route('laporan.index')->with('error', 'Hanya warga yang dapat membuat laporan.');
        }

        return view('laporan.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'warga') {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto_lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_lampiran')) {
            $fotoPath = $request->file('foto_lampiran')->store('laporan_fotos', 'public');
        }

        $laporan = Laporan::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'foto_lampiran' => $fotoPath,
            'status' => 'menunggu',
        ]);

        $rtUser = \App\Models\User::where('role', 'rt')->where('rt_number', Auth::user()->warga->rt_number)->first();
        if ($rtUser) {
            $rtUser->notify(new \App\Notifications\LaporanNotification($laporan, 'Ada laporan warga baru yang masuk.'));
        }

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim.');
    }

    public function show(Laporan $laporan)
    {
        $user = Auth::user();

        if ($user->role === 'warga' && $laporan->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role === 'rt' && $laporan->user->warga->rt_number !== $user->rt_number) {
            abort(403);
        }

        return view('laporan.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $user = Auth::user();

        if ($user->role === 'warga') {
            abort(403);
        }
        if ($user->role === 'rt' && $laporan->user->warga->rt_number !== $user->rt_number) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $laporan->update([
            'status' => $request->status,
        ]);

        $laporan->user->notify(new \App\Notifications\LaporanNotification($laporan, 'Status laporan Anda telah diperbarui menjadi ' . $request->status . '.'));

        return redirect()->route('laporan.show', $laporan->id)->with('success', 'Status laporan berhasil diperbarui.');
    }
}
