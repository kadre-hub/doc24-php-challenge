<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsuariosSeeder extends AbstractSeed
{   
  
    public function run(): void
    {
        $data = [
            ['nombre' => 'Diego', 'email' => 'diego@doc24.com.ar', 'password' => password_hash("doc24", PASSWORD_DEFAULT), 'secret_key' => password_hash("secreto", PASSWORD_DEFAULT)],
            ['nombre' => 'Pablo', 'email' => 'pablo@doc24.com.ar',  'password' => password_hash("doc24", PASSWORD_DEFAULT), 'secret_key' => password_hash("secreto", PASSWORD_DEFAULT)],
            ['nombre' => 'Hernan', 'email' => 'hernan@doc24.com.ar', 'password' =>  password_hash("doc24", PASSWORD_DEFAULT), 'secret_key' => password_hash("secreto", PASSWORD_DEFAULT)],
        ];       

        $usuarios = $this->table('usuarios');
        $usuarios->insert($data)
                 ->save();
    }
}
