<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\alumni>
 */
class AlumniFactory extends Factory
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
            'name' => $this->faker->name(),
            'jurusan' => $this->faker->word(2),
            'angkatan' => $this->faker->year(),
            'pekerjaan' => $this->faker->jobTitle(),
            'tempatKerja' => $this->faker->company(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
