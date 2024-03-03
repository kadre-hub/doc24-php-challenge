<?php 

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turno extends Illuminate\Database\Eloquent\Model
{
    protected $table = "turnos";
    protected $primaryKey = "id";
    protected $institucion_id = "institucion_id";
    protected $doctor_id = "doctor_id";
    protected $dia = "dia";
    protected $hora = "hora";
    public $timestamps = false;

    public function Doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function Institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
?>