<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
class JadwalFactory extends Factory
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
            'hari' => $this->faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
            'jam_mulai' => $this->faker->time('H:i'),
            'jam_selesai' => $this->faker->time('H:i'),
            'id_kelas' => $this->faker->numberBetween(1, 6),
            'id_mapel' => $this->faker->numberBetween(1, 6),
            'id_guru' => 2
        ];
    }
}
