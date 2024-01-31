<?php

namespace Database\Seeders;

use App\Models\MedicalTurns;
use Illuminate\Database\Seeder;

class MedicalTurnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 50 turns.
        foreach (range(1, 50) as $index) {
            // Get a random doctor.
            $doctorIndex = rand(1, 10);

            // Generate a random da.
            $day = rand(25, 31);
            $month = rand(2, 12);

            // Generate a random time.
            $hour = rand(8, 18);

            // Verify that the turn does not exist.
            $turn = MedicalTurns::where([
                'institution_id' => $index,
                'doctor_id' => $doctorIndex,
                'day' => '2024-' . $month . '-' . $day,
                'time' => $hour . ':00',
            ])->first();

            if ($turn) {
                continue;
            }

            MedicalTurns::create([
                'institution_id' => $index,
                'doctor_id' => $doctorIndex,
                'day' => '2024-' . $month . '-' . $day,
                'time' => $hour . ':00',
            ]);
        }
    }
}
