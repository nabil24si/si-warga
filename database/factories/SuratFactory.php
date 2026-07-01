<?php

namespace Database\Factories;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Surat>
 */
class SuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $jenisSurat = $faker->randomElement(['SKTM', 'Surat Pengantar KTP', 'Surat Keterangan Usaha', 'Surat Pengantar Nikah', 'Surat Domisili']);
        
        $dataTambahan = [];
        if ($jenisSurat === 'SKTM') {
            $dataTambahan = ['keperluan' => 'Pendidikan', 'nama_anak' => $faker->name(), 'sekolah' => 'SD Negeri ' . $faker->numberBetween(1, 10)];
        } elseif ($jenisSurat === 'Surat Keterangan Usaha') {
            $dataTambahan = ['nama_usaha' => 'Toko ' . $faker->lastName(), 'jenis_usaha' => 'Sembako', 'alamat_usaha' => $faker->address()];
        } else {
            $dataTambahan = ['keterangan' => $faker->sentence()];
        }

        $status = $faker->randomElement(['menunggu_rt', 'menunggu_rw', 'selesai', 'ditolak']);
        $keteranganDitolak = $status === 'ditolak' ? 'Dokumen tidak lengkap. Harap perbarui data KK.' : null;

        return [
            'jenis_surat' => $jenisSurat,
            'keperluan' => $faker->sentence(),
            'data_tambahan' => $dataTambahan,
            'status' => $status,
            'keterangan_penolakan' => $keteranganDitolak,
            'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
