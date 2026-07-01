<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Surat::with('user');

        if ($user->role === 'warga') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'rt') {
            // RT only sees surat from their RT
            $query->whereHas('user.warga', function($q) use ($user) {
                $q->where('rt_number', $user->rt_number);
            })->whereIn('status', ['menunggu_rt', 'menunggu_rw', 'selesai', 'ditolak']);
        } elseif ($user->role === 'rw') {
            // RW sees surat that passed RT
            $query->whereIn('status', ['menunggu_rw', 'selesai', 'ditolak']);
        }

        $surats = $query->latest()->paginate(10);
        return view('surat.index', compact('surats'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'warga') {
            return redirect()->route('surat.index')->with('error', 'Hanya warga yang dapat mengajukan surat.');
        }

        if (!Auth::user()->warga) {
            return redirect()->route('dashboard')->with('error', 'Harap lengkapi data profil warga Anda terlebih dahulu.');
        }

        return view('surat.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'warga') {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_surat' => 'required|string',
            'keperluan' => 'required|string',
        ]);

        $dataTambahan = null;
        $jenisSurat = $validated['jenis_surat'];

        if ($jenisSurat === 'Lainnya (Tulis Sendiri)') {
            $request->validate(['jenis_surat_lainnya' => 'required|string']);
            $jenisSurat = $request->jenis_surat_lainnya;
        }

        if ($validated['jenis_surat'] === 'Keterangan Pindah') {
            $request->validate([
                'alamat_asal' => 'required|string',
                'alamat_tujuan' => 'required|string',
            ]);
            $dataTambahan = [
                'alamat_asal' => $request->alamat_asal,
                'alamat_tujuan' => $request->alamat_tujuan,
            ];
        } elseif ($validated['jenis_surat'] === 'Keterangan Usaha') {
            $request->validate([
                'nama_usaha' => 'required|string',
                'bidang_usaha' => 'required|string',
            ]);
            $dataTambahan = [
                'nama_usaha' => $request->nama_usaha,
                'bidang_usaha' => $request->bidang_usaha,
            ];
        } elseif ($validated['jenis_surat'] === 'Surat Keterangan Domisili') {
            $request->validate([
                'lama_tinggal' => 'required|string',
                'alamat_sebelumnya' => 'required|string',
            ]);
            $dataTambahan = [
                'lama_tinggal' => $request->lama_tinggal,
                'alamat_sebelumnya' => $request->alamat_sebelumnya,
            ];
        } elseif ($validated['jenis_surat'] === 'Surat Keterangan Tidak Mampu (SKTM)') {
            $request->validate([
                'tujuan_penggunaan' => 'required|string',
                'pekerjaan_kepala_keluarga' => 'required|string',
            ]);
            $dataTambahan = [
                'tujuan_penggunaan' => $request->tujuan_penggunaan,
                'pekerjaan_kepala_keluarga' => $request->pekerjaan_kepala_keluarga,
            ];
        } elseif ($validated['jenis_surat'] === 'Surat Keterangan Kematian') {
            $request->validate([
                'nama_almarhum' => 'required|string',
                'tanggal_meninggal' => 'required|date',
                'tempat_meninggal' => 'required|string',
            ]);
            $dataTambahan = [
                'nama_almarhum' => $request->nama_almarhum,
                'tanggal_meninggal' => \Carbon\Carbon::parse($request->tanggal_meninggal)->format('d F Y'),
                'tempat_meninggal' => $request->tempat_meninggal,
            ];
        } elseif ($validated['jenis_surat'] === 'Surat Keterangan Kelahiran') {
            $request->validate([
                'nama_anak' => 'required|string',
                'nama_ayah' => 'required|string',
                'nama_ibu' => 'required|string',
            ]);
            $dataTambahan = [
                'nama_anak' => $request->nama_anak,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
            ];
        } elseif ($validated['jenis_surat'] === 'Surat Keterangan Belum Menikah') {
            $request->validate([
                'tujuan_penggunaan_belum_menikah' => 'required|string',
            ]);
            $dataTambahan = [
                'tujuan_penggunaan' => $request->tujuan_penggunaan_belum_menikah,
            ];
        }

        $surat = Surat::create([
            'user_id' => Auth::id(),
            'jenis_surat' => $jenisSurat,
            'keperluan' => $validated['keperluan'],
            'data_tambahan' => $dataTambahan,
            'status' => 'menunggu_rt',
        ]);

        $rtUser = \App\Models\User::where('role', 'rt')->where('rt_number', Auth::user()->warga->rt_number)->first();
        if ($rtUser) {
            $rtUser->notify(new \App\Notifications\SuratNotification($surat, 'Ada pengajuan surat baru dari warga.'));
        }

        return redirect()->route('surat.index')->with('success', 'Pengajuan surat berhasil dikirim ke RT.');
    }

    public function show(Surat $surat)
    {
        $user = Auth::user();

        // Check auth
        if ($user->role === 'warga' && $surat->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role === 'rt' && $surat->user->warga->rt_number !== $user->rt_number) {
            abort(403);
        }
        if ($user->role === 'rw' && $surat->status === 'menunggu_rt') {
            abort(403);
        }

        return view('surat.show', compact('surat'));
    }

    public function updateStatus(Request $request, Surat $surat)
    {
        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:setujui,tolak',
            'keterangan_penolakan' => 'required_if:status,tolak|nullable|string',
        ]);

        if ($user->role === 'rt' && $surat->status === 'menunggu_rt') {
            if ($request->status === 'setujui') {
                $surat->status = 'menunggu_rw';
            } else {
                $surat->status = 'ditolak';
                $surat->keterangan_penolakan = $request->keterangan_penolakan;
            }
            $surat->save();
            
            $surat->user->notify(new \App\Notifications\SuratNotification($surat, 'Status surat Anda telah diperbarui oleh RT.'));
            if ($surat->status === 'menunggu_rw') {
                $rwUser = \App\Models\User::where('role', 'rw')->first();
                if ($rwUser) {
                    $rwUser->notify(new \App\Notifications\SuratNotification($surat, 'Ada pengajuan surat baru yang telah disetujui RT.'));
                }
            }

            return redirect()->route('surat.show', $surat->id)->with('success', 'Status surat berhasil diperbarui (RT).');
        }

        if ($user->role === 'rw' && $surat->status === 'menunggu_rw') {
            if ($request->status === 'setujui') {
                $surat->status = 'selesai';
            } else {
                $surat->status = 'ditolak';
                $surat->keterangan_penolakan = $request->keterangan_penolakan;
            }
            $surat->save();
            
            $surat->user->notify(new \App\Notifications\SuratNotification($surat, 'Status surat Anda telah diperbarui oleh RW.'));

            return redirect()->route('surat.show', $surat->id)->with('success', 'Status surat berhasil diperbarui (RW).');
        }

        abort(403, 'Anda tidak berhak mengubah status surat ini saat ini.');
    }

    public function cetakPdf(Surat $surat)
    {
        if ($surat->status !== 'selesai') {
            abort(403, 'Surat belum selesai diproses.');
        }

        $user = Auth::user();
        if ($user->role === 'warga' && $surat->user_id !== $user->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('surat.pdf', compact('surat'));
        return $pdf->stream('Surat-' . $surat->jenis_surat . '.pdf');
    }
}
