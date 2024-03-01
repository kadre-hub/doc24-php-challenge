<?php 
use Illuminate\Database\Eloquent\Relations\HasMany;
class Doctor extends Illuminate\Database\Eloquent\Model
{
    protected $table = "doctores";
    protected $primaryKey = "id";
    protected $nombre = "nombre";
    public $timestamps = false;

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
?>