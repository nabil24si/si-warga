<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warga;
use App\Models\Surat;
use App\Models\Laporan;
use App\Models\KasKeuangan;
use App\Models\Pengumuman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = fake('id_ID');
        $pengurusIds = [];

        // 1. Buat Pengurus Inti (Hardcode)
        $rw = User::firstOrCreate(
            ['email' => 'rw@suaklanjut.com'],
            [
                'name' => 'Pengurus RW',
                'password' => Hash::make('password'),
                'role' => 'rw',
                'status_akun' => 'aktif',
                'phone_number' => '0811111111',
            ]
        );
        $pengurusIds[] = $rw->id;

        $rts = ['01', '02', '03', '04', '05', '06', '07'];
        foreach ($rts as $rtNumber) {
            $rtUser = User::firstOrCreate(
                ['email' => "rt{$rtNumber}@suaklanjut.com"],
                [
                    'name' => "Pengurus RT {$rtNumber}",
                    'password' => Hash::make('password'),
                    'role' => 'rt',
                    'rt_number' => $rtNumber,
                    'status_akun' => 'aktif',
                    'phone_number' => '082222222' . (int)$rtNumber,
                ]
            );
            $pengurusIds[] = $rtUser->id;
        }

        $allWargaIds = [];

        // 2. Looping Warga (Demografi)
        foreach ($rts as $rtNumber) {
            // 30 KK per RT
            for ($kk = 1; $kk <= 30; $kk++) {
                $no_kk = $faker->numerify('140#############');
                $jumlahAnggotaKeluarga = $faker->numberBetween(2, 5);

                for ($anggota = 1; $anggota <= $jumlahAnggotaKeluarga; $anggota++) {
                    $isKepalaKeluarga = ($anggota === 1);
                    
                    // Generate User
                    $user = User::factory()->create([
                        'rt_number' => $rtNumber,
                    ]);
                    
                    $allWargaIds[] = $user->id;

                    // Override specific fields for Kepala Keluarga
                    $statusPerkawinan = 'Belum Kawin';
                    if ($isKepalaKeluarga) {
                        $statusPerkawinan = $faker->randomElement(['Kawin', 'Cerai Hidup', 'Cerai Mati']);
                    } else {
                        // Jika bukan KK (Istri/Anak), bisa kawin/belum
                        $statusPerkawinan = $faker->randomElement(['Belum Kawin', 'Kawin']);
                    }

                    // Generate Warga relation
                    Warga::factory()->create([
                        'user_id' => $user->id,
                        'no_kk' => $no_kk,
                        'rt_number' => $rtNumber,
                        'status_perkawinan' => $statusPerkawinan,
                        // Nama disamakan dengan User
                        'nama_lengkap' => $user->name,
                    ]);
                }
            }
        }

        // 3. Looping Interaksi & Layanan (40% Warga Aktif)
        $totalWarga = count($allWargaIds);
        $wargaAktifCount = (int) ($totalWarga * 0.4);
        
        // Pilih ID acak
        $wargaAktifIds = $faker->randomElements($allWargaIds, $wargaAktifCount);

        foreach ($wargaAktifIds as $wargaId) {
            // 1-3 Surat
            $jumlahSurat = $faker->numberBetween(1, 3);
            Surat::factory()->count($jumlahSurat)->create([
                'user_id' => $wargaId
            ]);

            // 0-2 Laporan
            $jumlahLaporan = $faker->numberBetween(0, 2);
            if ($jumlahLaporan > 0) {
                Laporan::factory()->count($jumlahLaporan)->create([
                    'user_id' => $wargaId
                ]);
            }
        }

        // 4. Looping Keuangan & Pengumuman
        // Generate ~50 KasKeuangan assigned randomly to Pengurus (RT/RW)
        for ($i = 0; $i < 50; $i++) {
            KasKeuangan::factory()->create([
                'user_id' => $faker->randomElement($pengurusIds)
            ]);
        }

        // Generate 10 Pengumuman
        for ($i = 0; $i < 10; $i++) {
            Pengumuman::factory()->create([
                'user_id' => $faker->randomElement($pengurusIds)
            ]);
        }
    }
}
