<?php 

class Usuario extends Illuminate\Database\Eloquent\Model
{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    protected $nombre = "nombre";
    protected $email = "email";
    protected $password = "password";
    protected $secret_key = "secret_key";
    protected $rememberToken = "rememberToken";
    public $timestamps = false;
  
}
?>