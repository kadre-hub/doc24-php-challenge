<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDoctoresTable extends AbstractMigration
{    
    public function change(): void
    {
        $table = $this->table('doctores');
        $table->addColumn('nombre', 'string')
              ->addTimestamps()
              ->create();
    }
}
