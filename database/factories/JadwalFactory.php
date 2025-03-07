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
            'hari' => $this->faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']),
            'waktu_id' => $this->faker->numberBetween(1, 6),
            'kelas_id' => $this->faker->numberBetween(1, 6),
            'mapel_id' => $this->faker->numberBetween(1, 6),
            'guru_id' => 2
        ];
    }
}
