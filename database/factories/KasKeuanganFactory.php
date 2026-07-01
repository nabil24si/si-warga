<?php

namespace Database\Factories;

use App\Models\KasKeuangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KasKeuangan>
 */
class KasKeuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $jenisTransaksi = $faker->randomElement(['pemasukan', 'pengeluaran']);
        
        $kategoriPemasukan = ['Iuran Warga', 'Donasi', 'Bantuan Desa'];
        $kategoriPengeluaran = ['Perbaikan Infrastruktur', 'Konsumsi Rapat', 'Kegiatan Warga', 'Bantuan Sosial'];
        
        $kategori = $jenisTransaksi === 'pemasukan' 
            ? $faker->randomElement($kategoriPemasukan) 
            : $faker->randomElement($kategoriPengeluaran);
            
        return [
            'jenis_transaksi' => $jenisTransaksi,
            'kategori' => $kategori,
            'nominal' => $faker->numberBetween(5, 150) * 10000, // Rp 50.000 to Rp 1.500.000
            'tanggal_transaksi' => $faker->dateTimeBetween('-6 months', 'now'),
            'keterangan' => $faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
