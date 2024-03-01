<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTurnosTable extends AbstractMigration
{   
    public function change(): void
    {                   
        $table = $this->table('turnos');
        $table->addColumn('doctor_id', 'integer')
      ->addColumn('institucion_id', 'integer')
      ->addColumn('dia', 'date')
      ->addColumn('hora', 'time')
      ->addTimestamps()     
      ->addIndex(['doctor_id', 'dia', 'hora'], ['unique' => true])     
      ->create();
    }
}
