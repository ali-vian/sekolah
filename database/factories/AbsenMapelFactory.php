<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbsenMapel>
 */
class AbsenMapelFactory extends Factory
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
            'jadwal_id' => $this->faker->numberBetween(3, 6),
            'student_id' => $this->faker->numberBetween(3, 6),
            'status' => $this->faker->randomElement(['Hadir', 'Absen','Izin','Sakit']),
            'keterangan' => $this->faker->sentence(),
            'waktu_absen' => $this->faker->dateTimeThisYear(),
        ];
    }
}
