<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materi>
 */
class MateriFactory extends Factory
{
    protected $model = Materi::class; // Menentukan bahwa factory ini terkait dengan model Materi.
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
            'file' => $this->faker->word . '.pdf', // Format file PDF, contoh dokumen.pdf
            'video' => $this->faker->word . '.mp4', // Format video MP4, contoh video.mp4
        ];
    }
}
