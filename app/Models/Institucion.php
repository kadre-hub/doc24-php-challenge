<?php 
use Illuminate\Database\Eloquent\Relations\HasMany;
class Institucion extends Illuminate\Database\Eloquent\Model
{
    protected $table = "instituciones";
    protected $primaryKey = "id";
    protected $nombre = "nombre";    
    public $timestamps = false;

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
   
}
?>