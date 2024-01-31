<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 doctors.
        foreach (range(1, 10) as $index) {
            Doctor::create([
                'name' => 'Doctor ' . $index,
            ]);
        }
    }
}
