<?php
namespace App\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Turno;
use Doctor;
use Institucion;
use Respect\Validation\Validator as v;

class TurnosController
{
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
        $status = 200;
    } else {
        $responseData = [
            'success' => false,
            'message' => 'El turno ' . $id . ' no existe',
            'descripcion' => 'Nada para mostrar'
        ];
        $status = 404;
       }

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
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
        
        if (empty($data['institucion_id']) || empty($data['doctor_id']) || empty($data['dia']) || empty($data['hora'])) {
            $validacionDatos = true;
        }
        
        if ($validacionDatos) {
            $mensaje[] = "Por favor rellenar los campos correctamente: doctor_id, institucion_id, fecha y día";
            $response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'El turno no fue dado de alta',
                'errores' => $mensaje
                ]));  
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }          
        
        $Turno = new Turno();
        
        $ExisteDoctor = Doctor::where("id", $data['doctor_id'])->count();
        $ExisteInstitucion = Institucion::where("id", $data['institucion_id'])->count(); 
        $ExisteTurno = Turno::where('doctor_id', $data['doctor_id'])
            ->where('dia', $data['dia'])
            ->where('hora', $data['hora'])
            ->count();
        
        if ($ExisteDoctor == 0 || $ExisteInstitucion == 0) {
            $validacionDatos = true;
            $mensaje[] = "El doctor o la institución no existen";
        }
        if ($ExisteTurno != 0) {
            $validacionDatos = true;
            $mensaje[] = "El turno ya existe o el doctor está ocupado en otra institución en esta fecha y hora.";
        }
        
        if (!v::date('Y-m-d')->validate($data['dia']) || !v::regex('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/')->validate($data['hora'])) {
            $validacionDatos = true;
            $mensaje[] ="Fecha u hora incorrecta.";      
          }  

        if (!$validacionDatos) {
            $status = 200;
            $Turno->doctor_id = $data['doctor_id'];
            $Turno->institucion_id = $data['institucion_id'];
            $Turno->dia = $data['dia'];
            $Turno->hora = $data['hora'];
            $Turno->save();   
            
            $Turno->load('doctor', 'institucion');
            $response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'El turno fue dado de alta',
                'descripción' => $Turno
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
            $status = 404;
        }
        
        $responseData = [
            'success' => $success,
            'message' => $message
        ];
        
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);

        }

        //In progress, no está listo
       public function actualizarTurno(RequestPatch $request, ResponsePatch $response, $args){
        $data = $request->getParsedBody();
        $id = $args['id'];
        $Turno = Turno::find($id);
        if (!$Turno) {
            $response->getBody()->write("Turno no encontrado");
            return $response->withStatus(404);
        }
        
        $camposActualizados = 0;
        
        foreach (['institucion_id', 'doctor_id', 'dia', 'hora'] as $campo) {
            if (isset($data[$campo])) {
                $Turno->$campo = $data[$campo];
                $camposActualizados++;
            }
        }
        
        if ($camposActualizados > 0) {
            $Turno->save();
            $response->getBody()->write("Turno actualizado");
        } else {
            $response->getBody()->write("Ningún campo para actualizar");
        }
        
        return $response;          
      }
}
