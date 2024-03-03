<?php
namespace App\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Turno;
use Doctor;
use Institucion;
use Respect\Validation\Validator as v;
use App\Traits\ValidacionDatosTrait;

class TurnosController
{
    use ValidacionDatosTrait;
    public function obtenerTurno(Request $request, Response $response, $args)
    {
    $id = $args['id'];
    $turno = Turno::with('doctor', 'institucion')->find($id);

    if ($turno) {
        $responseData = [
            'success' => true,
            'message' => 'Turno obtenido con éxito',
            'descripcion' => $turno
        ];
       
    } else {
        $responseData = [
            'success' => false,
            'message' => 'El turno ' . $id . ' no existe',
            'descripcion' => 'Nada para mostrar'
        ];
       
       }

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function obtenerTurnos(Request $request, Response $response, $args){
        $turnos = Turno::with('doctor', 'institucion')->get();
      
        if ($turnos->isEmpty()) {
    
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'No se encontraron turnos en la base de datos'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        } else {
      
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Todos los turnos fueron obtenidos',
                'descripcion' => $turnos
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
      }

    public function altaTurno(Request $request, Response $response, $args){
        $mensaje = [];
        $data = $request->getParsedBody();
        $validacionDatos = false;
        
        $camposRequeridos = ['institucion_id', 'doctor_id', 'dia', 'hora'];
        foreach ($camposRequeridos as $campo) {
            if (empty($data[$campo])) {
                $validacionDatos = true;
                $mensaje[] = "Por favor rellenar los campos correctamente: $campo";
            }
        }
        
        if (empty($mensaje)) {
            
            $metodo = "alta";        
            list($validacionDatos, $mensaje) = $this->validarDatos($data['doctor_id'], $data['institucion_id'], $data['dia'],$data['hora'], $metodo);
               
        }
        
        if (!$validacionDatos) {
            $status = 201;
            $turno = new Turno();  
            $turno->doctor_id = $data['doctor_id'];
            $turno->institucion_id = $data['institucion_id'];
            $turno->dia = $data['dia'];
            $turno->hora = $data['hora'];
            $turno->save();   
            
            $turno->load('doctor', 'institucion');
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'El turno fue dado de alta',
                'descripción' => $turno
            ]));               
        } else {
            $status = 400;
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'El turno no fue dado de alta',
                'errores' => $mensaje
            ]));   
        }
        
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    public function cancelarTurno(Request $request, Response $response, $args){
        $id = $args['id'];
        $turno = Turno::find($id);
        
        if ($turno) {
            $turno->delete();
            $message = "El turno #$id fue cancelado";
            $success = true;
            $status = 200;
        } else {
            $message = "El turno $id no existe";
            $success = false;
            $status = 400;
        }
        
        $responseData = [
            'success' => $success,
            'message' => $message
        ];
        
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);

        }

       public function actualizarTurno(Request $request, Response $response, $args){
        $mensaje        = [];
        $data           = $request->getParsedBody();
        $id             = $args['id'];
        $Turno          = Turno::find($id);
        $validacionDatos = false;

        if (!$Turno) {
            $validacionDatos = true;
            $mensaje[] = "El turno no existe";        
        }
        
        $doctor_id      = $data['doctor_id'] ?? $Turno->doctor_id;
        $institucion_id = $data['institucion_id'] ?? $Turno->institucion_id;
        $dia            = $data['dia'] ?? $Turno->dia;
        $hora           = $data['hora'] ?? $Turno->hora;
        $metodo         = "actualizar";
        
        list($validacionDatos, $mensaje) = $this->validarDatos($doctor_id, $institucion_id, $dia, $hora, $metodo, $id);
        
        $camposActualizados = 0;
        
        foreach (['institucion_id', 'doctor_id', 'dia', 'hora'] as $campo) {
            if (isset($data[$campo])) {
                $Turno->$campo = $data[$campo];
                $camposActualizados++;
            }
        }
        if ($camposActualizados > 0 && !$validacionDatos) {
            $status = 200;
            $Turno->save();
            $Turno->load('doctor', 'institucion');
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'El turno fue modificado',
                'descripción' => $Turno
            ]));   
        } else {
            $status = 400;
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Ningún campo para actualizar',
                'errores' => $mensaje
            ])); 
        }
        
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
        }
}
