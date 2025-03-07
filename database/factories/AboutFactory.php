<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\About>
 */
class AboutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
            'fasilitas' => json_encode([$this->faker->word(), $this->faker->word(), $this->faker->word()]),
            'sambutan' => $this->faker->text(),
            'gambar_sambutan' => $this->faker->imageUrl(),
            'sejarah' => $this->faker->text(),
            'gambar_sejarah' => $this->faker->imageUrl(),
            'visi' => $this->faker->text(),
            'gambar_visi' => $this->faker->imageUrl(),
            'misi' => $this->faker->text()
        ];
    }
}
