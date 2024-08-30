<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Program;
use App\Models\Pengumpulan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengumpulan>
 */
class PengumpulanFactory extends Factory
{
    protected $model = Pengumpulan::class; // Menentukan bahwa factory ini terkait dengan model Pengumpulan.
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
            'tugas_id' => Tugas::inRandomOrder()->first()->id ?? Tugas::factory(),
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'file' => $this->faker->word . '.pdf', // ini nanti menambahkan format pdf, contoh dokumen.pdf
            'status' => $this->faker->randomElement(['Sudah Mengumpulkan']),
            'file_path' => $this->faker->word . '.pdf',
        ];
    }
}
