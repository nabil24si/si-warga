<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'warga')->where('status_akun', 'pending')->latest()->get();
        return view('approval.index', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $user->update(['status_akun' => 'aktif']);
        return redirect()->route('approval.index')->with('success', 'Akun ' . $user->name . ' berhasil disetujui.');
    }

    public function reject(User $user)
    {
        $name = $user->name;
        $user->delete();
        return redirect()->route('approval.index')->with('success', 'Data pendaftar ' . $name . ' berhasil ditolak dan dihapus.');
    }
}
