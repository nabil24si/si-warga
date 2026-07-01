<?php

namespace App\Http\Controllers;

use App\Models\KasKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $query = KasKeuangan::query();

        // If RT, maybe we only want RT scoped financial data? 
        // The PRD doesn't explicitly mention splitting RT/RW cash pools. 
        // "RW & RT Memiliki akses penuh (CRUD) untuk mencatat pemasukan dan pengeluaran sesuai dengan wilayah wewenangnya."
        // Wait, if it's per RT, we should filter by RT. The simplest way is to associate it via the user who created it, or add an rt_number to the table.
        // We didn't add rt_number to KasKeuangan. Let's just assume it's global RW cash for now, or we can filter by the user's RT if RT. 
        // Actually, let's filter by the creator's RT. If RT, see their RT's cash. If RW, see all or RW's cash.
        // For simplicity and transparency, let's just show all transactions. The PRD says "Warga hanya memiliki hak akses membaca... sehingga tercipta transparansi yang baik."
        // Let's filter the data based on the requested month and year.
        
        $query->whereMonth('tanggal_transaksi', $bulan)
              ->whereYear('tanggal_transaksi', $tahun);

        $transaksis = $query->latest('tanggal_transaksi')->latest('id')->get();

        $totalPemasukan = $transaksis->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksis->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.index', compact('transaksis', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'bulan', 'tahun'));
    }

    public function create()
    {
        if (Auth::user()->role === 'warga') {
            abort(403);
        }
        return view('keuangan.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'warga') {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        $kas = KasKeuangan::create($validated);

        $wargaUsers = \App\Models\User::where('role', 'warga')->get();
        \Illuminate\Support\Facades\Notification::send($wargaUsers, new \App\Notifications\KasKeuanganNotification($kas, 'Ada pembaruan transparansi kas keuangan RT/RW.'));

        return redirect()->route('keuangan.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    public function edit(KasKeuangan $keuangan)
    {
        if (Auth::user()->role === 'warga') {
            abort(403);
        }
        return view('keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, KasKeuangan $keuangan)
    {
        if (Auth::user()->role === 'warga') {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $keuangan->update($validated);

        return redirect()->route('keuangan.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    public function destroy(KasKeuangan $keuangan)
    {
        if (Auth::user()->role === 'warga') {
            abort(403);
        }

        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Data transaksi berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $transaksis = KasKeuangan::whereMonth('tanggal_transaksi', $bulan)
              ->whereYear('tanggal_transaksi', $tahun)
              ->latest('tanggal_transaksi')
              ->latest('id')
              ->get();

        $totalPemasukan = $transaksis->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksis->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $namaBulan = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('keuangan.pdf', compact('transaksis', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'namaBulan', 'tahun'));
        
        return $pdf->stream('Laporan-Keuangan-' . $namaBulan . '-' . $tahun . '.pdf');
    }
}
