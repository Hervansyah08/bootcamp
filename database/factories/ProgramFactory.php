<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class; // Menentukan bahwa factory ini terkait dengan model Program.
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama' => $this->faker->randomKey([
                'Digital Marketing' => 'Digital Marketing',
                'Web' => 'Web',
                'Mobile' => 'Mobile',
            ]),
            'deskripsi' => $this->faker->paragraph,
        ];
    }
}
