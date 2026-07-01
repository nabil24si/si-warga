<?php

namespace Database\Factories;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Laporan>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $judulList = ['Jalan berlubang di depan masjid', 'Lampu PJU mati di gang Mawar', 'Tumpukan sampah belum diangkut', 'Saluran air tersumbat', 'Pohon tumbang menghalangi jalan'];
        
        return [
            'judul' => $faker->randomElement($judulList),
            'deskripsi' => $faker->paragraph(),
            'foto_lampiran' => null, // keep null or generate fake url later
            'status' => $faker->randomElement(['menunggu', 'diproses', 'selesai']),
            'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
