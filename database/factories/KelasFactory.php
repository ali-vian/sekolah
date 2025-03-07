<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
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
            'nama_kelas' => $this->faker->randomElement(['X TKJ', 'XI TKJ', 'XII TKJ', 'X TSM', 'XI TSM', 'XII TSM']),
            'walikelas' => 3,
            'jurusan' => $this->faker->randomElement(['Teknik Komputer Jaringan', 'Teknik Sepeda Motor']),
        ];
    }
}
