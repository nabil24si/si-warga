<?php

namespace Database\Factories;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $pekerjaans = ['Belum/Tidak Bekerja', 'Pelajar/Mahasiswa', 'PNS', 'Karyawan Swasta', 'Wiraswasta', 'Buruh Harian Lepas', 'Mengurus Rumah Tangga'];
        
        return [
            'nik' => $faker->numerify('140#############'), // Riau code example or just random
            'no_kk' => $faker->numerify('140#############'),
            'nama_lengkap' => $faker->name(),
            'tempat_lahir' => $faker->city(),
            'tanggal_lahir' => $faker->dateTimeBetween('-70 years', '-1 years')->format('Y-m-d'),
            'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
            'agama' => $faker->randomElement($agamas),
            'pekerjaan' => $faker->randomElement($pekerjaans),
            'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
            'rt_number' => $faker->randomElement(['01', '02', '03']),
        ];
    }
}
