<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class DoctoresSeeder extends AbstractSeed
{   
    public function run(): void
    {
        $data = [
            [
                'nombre' => 'Doctor Cormillot'
            ],
            [
                'nombre' => 'Doctor Rosetti'
            ]
        ];

        $doctores = $this->table('doctores');
        $doctores->insert($data)
                 ->save();
    }
}
