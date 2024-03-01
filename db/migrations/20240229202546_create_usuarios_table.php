<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsuariosTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('usuarios');
        $table->addColumn('nombre', 'string')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string') 
            ->addColumn('rememberToken', 'string') 
            ->addIndex(['email'], ['unique' => true])
            ->addTimestamps()     
            ->create();     
    }
}
