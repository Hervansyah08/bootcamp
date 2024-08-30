<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Program;
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
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'program_id' => Program::inRandomOrder()->first()->id ?? Program::factory(),
            'judul' => $this->faker->sentence,
            'detail' => $this->faker->paragraph,
            'link' => $this->faker->url,
        ];
    }
}
