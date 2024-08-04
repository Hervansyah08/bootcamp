<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Master;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Master>
 */
class MasterFactory extends Factory
{
    protected $model = Master::class; // Menentukan bahwa factory ini terkait dengan model Master.
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'email' => $this->faker->unique()->safeEmail,
            'nama' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Pria', 'Wanita']),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address,
            'no_hp' => $this->faker->phoneNumber,
            'status_pekerjaan' => $this->faker->randomElement(['Pelajar', 'Fresh Graduate','Keryawan']),
            'instansi' => $this->faker->company,
            'program_id' => Program::inRandomOrder()->first()->id ?? Program::factory(),
            'info' => $this->faker->randomElement(['Instagram', 'FB','Keluarga']),
            'motivasi' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Active', 'Pending']),
        ];
    }
}
