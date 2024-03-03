<?php

namespace App\Traits;

use Doctor;
use Institucion;
use Turno;
use Respect\Validation\Validator as v;

trait ValidacionDatosTrait
{
    public function validarDatos($doctor_id, $institucion_id, $dia, $hora, $metodo, $id = null)
    {
        $validacionDatos = false;
        $mensaje = [];

        $existeDoctor = Doctor::where("id", $doctor_id)->exists();
        $existeInstitucion = Institucion::where("id", $institucion_id)->exists();
        if($metodo == "alta"){
            $existeTurno = Turno::where('doctor_id', $doctor_id)
            ->where('dia', $dia)
            ->where('hora', $hora)
            ->exists();
        }
        else{
        $existeTurno = Turno::where('doctor_id', $doctor_id)
            ->where('dia', $dia)
            ->where('hora', $hora)
            ->where('id', '<>', $id)
            ->exists();
        }

        if (!$existeDoctor || !$existeInstitucion) {
            $validacionDatos = true;
            $mensaje[] = "El doctor o la institución no existen";
        }

        if ($existeTurno) {
            $validacionDatos = true;
            $mensaje[] = "El turno ya existe o el doctor está ocupado en otra institución en esta fecha y hora.";
        }

        if (!v::date('Y-m-d')->validate($dia) || !v::regex('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/')->validate($hora)) {
            $validacionDatos = true;
            $mensaje[] ="Fecha u hora incorrecta.";
        }

        return [$validacionDatos, $mensaje];
    }
}
