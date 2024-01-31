<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 institutions.
        foreach (range(1, 10) as $index) {
            Institution::create([
                'name' => 'Institution ' . $index,
            ]);
        }
    }
}
