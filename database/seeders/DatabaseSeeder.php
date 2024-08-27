<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tugas;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Master;
use App\Models\Materi;
use App\Models\Program;
use App\Models\Pengumpulan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Program::factory(10)->create();
        Master::factory(10)->create();
        Materi::factory(10)->create();
        Tugas::factory(10)->create();
        Pengumpulan::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
