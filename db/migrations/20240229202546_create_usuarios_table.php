<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsuariosTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('usuarios');
        $table->addColumn('nombre', 'string', ['null' => false])
            ->addColumn('email', 'string', ['null' => false])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('secret_key', 'string', ['null' => false])
            ->addColumn('rememberToken', 'string') 
            ->addColumn('statusToken', 'boolean', ['default' => 0]) 
            ->addIndex(['email'], ['unique' => true])
            ->addTimestamps()     
            ->create();     
    }
}
