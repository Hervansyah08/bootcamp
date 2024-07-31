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
        User::factory(10)->create(); // 160
        Program::factory(10)->create(); // 80
        Master::factory(10)->create(); // 10
        Materi::factory(10)->create(); //30
        Tugas::factory(10)->create(); // 20
        Pengumpulan::factory(10)->create(); // 10

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
