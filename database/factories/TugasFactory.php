<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tugas>
 */
class TugasFactory extends Factory
{
    protected $model = Tugas::class; // Menentukan bahwa factory ini terkait dengan model Tugas.
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
            'deskripsi' => $this->faker->paragraph,
            'file' => $this->faker->word . '.pdf', // ini nanti menambahkan format pdf, contoh dokumen.pdf
            'deadline' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
