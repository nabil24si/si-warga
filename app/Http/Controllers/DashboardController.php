<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\Surat;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pengumumans = Pengumuman::with('user')->where('is_active', true)->latest()->get();

        if ($user->role === 'warga') {
            $suratTerbaru = Surat::where('user_id', $user->id)->latest()->take(5)->get();
            $laporanTerbaru = Laporan::where('user_id', $user->id)->latest()->take(5)->get();

            return view('warga.dashboard', compact('user', 'pengumumans', 'suratTerbaru', 'laporanTerbaru'));
        }

        if ($user->role === 'rw' || $user->role === 'rt') {
            $totalRt = \App\Models\User::where('role', 'rt')->where('status_akun', 'aktif')->count();
            
            $wargaQuery = \App\Models\User::where('role', 'warga');
            $pendingQuery = \App\Models\User::where('role', 'warga')->where('status_akun', 'pending');
            $kkQuery = \App\Models\Warga::query();

            if ($user->role === 'rt') {
                $wargaQuery->where('rt_number', $user->rt_number);
                $pendingQuery->where('rt_number', $user->rt_number);
                $kkQuery->where('rt_number', $user->rt_number);
            }

            $totalWarga = $wargaQuery->where('status_akun', 'aktif')->count();
            $pendingWarga = $pendingQuery->count();
            $totalKk = $kkQuery->distinct('no_kk')->count('no_kk');

            return view('dashboard', compact('user', 'pengumumans', 'totalRt', 'totalWarga', 'pendingWarga', 'totalKk'));
        }

        return view('dashboard', compact('user', 'pengumumans'));
    }
}
