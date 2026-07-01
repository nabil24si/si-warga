<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Only RW and RT can manage pengumuman
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        $pengumumans = Pengumuman::latest()->paginate(10);
        return view('pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = $user->id;
        $validated['is_active'] = $request->has('is_active');

        $pengumuman = Pengumuman::create($validated);

        if ($pengumuman->is_active) {
            $wargaUsers = \App\Models\User::where('role', 'warga')->get();
            \Illuminate\Support\Facades\Notification::send($wargaUsers, new \App\Notifications\PengumumanNotification($pengumuman, 'Ada pengumuman baru dari pengurus.'));
        }

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            abort(403, 'Unauthorized action.');
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
