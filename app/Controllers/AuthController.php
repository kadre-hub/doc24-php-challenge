<?php
namespace App\Controllers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Usuario;
use Respect\Validation\Validator as v;
use Firebase\JWT\JWT;

class AuthController
{
    public function login(Request $request, Response $response, $args)
    {
    $data         = $request->getParsedBody();
    $email        = $data['email'] ?? '';
    $passwordForm = $data['password'] ?? '';

 //   $usuario = Usuario::where("email", $email)->first();
    $usuario = Usuario::whereRaw('BINARY email = ?', [$email])->first();
    if ($usuario && password_verify($passwordForm, $usuario->password)) {

        $payload = [
            "sub" => $email,
            "exp" => time() + 3600 
        ];
        $header = [
            "alg" => "HS256",
            "typ" => "JWT",
            "kid" => "mi_clave_unico"
        ];
       
        $token = JWT::encode($payload, $usuario->secret_key, 'HS256', null, $header);
        $usuario->rememberToken =  $token;
        $usuario->statusToken = 1;  
        $usuario->save();
        
        $response->getBody()->write(json_encode(['token' => $token]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['error' => 'Credenciales inválidas']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    }
}


public function logout(Request $request, Response $response, $args)
{
    $token = $request->getHeaderLine('Authorization');
    $explodeToken = explode(" ",$token);
    $Usuario = Usuario::where("rememberToken", $explodeToken[1])
    ->where("statusToken",1)
    ->first();

    if ($Usuario !== null) { 
        $Usuario->statusToken = 0;
        $Usuario->save();  
        $responseData = [
            'success' => true,
            'message' => 'Usuario deslogueado con éxito'           
        ];
        $status = 200;
    } else {
        $responseData = [
            'success' => false,
            'message' => 'El token es inválido o ya está revocado anteriormente',
            
        ];
        $status = 404;
       }

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
   
}

}