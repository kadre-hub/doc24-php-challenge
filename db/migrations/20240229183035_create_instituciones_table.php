<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateInstitucionesTable extends AbstractMigration
{    
    public function change(): void
    {
        $table = $this->table('instituciones');
        $table->addColumn('nombre', 'string')
              ->addTimestamps()
              ->create();
    }
}
