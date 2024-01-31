<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DoctorSeeders;
use Database\Seeders\UserSeeder;
use Database\Seeders\MedicalTurnsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DoctorSeeders::class,
            InstitutionSeeder::class,
            MedicalTurnsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
