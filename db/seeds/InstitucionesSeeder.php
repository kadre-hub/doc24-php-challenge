<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class InstitucionesSeeder extends AbstractSeed
{   
    public function run(): void
    {
        $data = [
            [
                'nombre' => 'Grupo Gamma'
            ],
            [
                'nombre' => 'Americano'
            ]
        ];

        $instituciones = $this->table('instituciones');
        $instituciones->insert($data)
                 ->save();
    }
}
