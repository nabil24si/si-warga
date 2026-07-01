<?php

namespace Database\Factories;

use App\Models\Pengumuman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengumuman>
 */
class PengumumanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $judulList = ['Undangan Kerja Bakti', 'Rapat RT Bulanan', 'Jadwal Siskamling Terbaru', 'Pengumuman Lomba 17 Agustus', 'Pembagian Bantuan Sosial'];
        
        return [
            'judul' => $faker->randomElement($judulList),
            'konten' => $faker->paragraphs(3, true),
            'is_active' => $faker->boolean(80), // 80% chance of being active
            'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
