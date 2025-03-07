<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurusan>
 */
class JurusanFactory extends Factory
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
            'description' => $this->faker->text(),
            'icon' => $this->faker->text(),
            'slug' => $this->faker->text(),
            'prospek_kerja' => $this->faker->text(),
            'kompetensi' => $this->faker->text(),
            'gambar' => $this->faker->text()
        ];
    }
}
