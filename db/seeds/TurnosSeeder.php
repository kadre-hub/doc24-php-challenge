<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TurnosSeeder extends AbstractSeed
{   
    public function run(): void
    {
        $data = [
            [
                'doctor_id' => 1,            
                'institucion_id' => 1,            
                'dia' => "2024-05-01",            
                'hora' => "12:00"
            ],
            [
                'doctor_id' => 2,            
                'institucion_id' => 3,            
                'dia' => "2024-05-02",            
                'hora' => "12:30"
            ],
        ];

        $turnos = $this->table('turnos');
        $turnos->insert($data)
                 ->save();
    }
}
