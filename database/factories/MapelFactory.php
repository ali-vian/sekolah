<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mapel>
 */
class MapelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama_mapel' => $this->faker->randomElement(['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Kimia', 'Biologi']),
            'jenjang' => $this->faker->randomElement(['X', 'XI', 'XII']),
            'jurusan' => $this->faker->randomElement(['Teknik Komputer Jaringan', 'Teknik Sepeda Motor']),
            'kode_mapel' => $this->faker->unique()->randomNumber(8),
        ];
    }
}
