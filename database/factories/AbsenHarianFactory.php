<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbsenHarian>
 */
class AbsenHarianFactory extends Factory
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
            'student_id' => $this->faker->numberBetween(3, 6),
            'status' => $this->faker->randomElement(['Hadir', 'Absen','Izin','Sakit']),
            'waktu_absen' => $this->faker->dateTimeThisYear(),
        ];
    }
}
