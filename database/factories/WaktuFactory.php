<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Waktu>
 */
class WaktuFactory extends Factory
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
            'nama' => $this->faker->randomElement(['Jam ke-1', 'Jam ke-2', 'Jam ke-3', 'Jam ke-4', 'Jam ke-5', 'Jam ke-6']),
            'waktu_mulai' => $this->faker->time(),
            'waktu_selesai' => $this->faker->time(),
        ];
    }
}
