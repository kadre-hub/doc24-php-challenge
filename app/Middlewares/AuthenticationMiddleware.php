<?php
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationMiddleware
{
     public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $bearer_token = $request->getHeaderLine('Authorization');
        $explodeToken = explode(" ",$bearer_token);  
        if (isset($explodeToken[1])) {
            $token = $explodeToken[1];     
        }
        
        if (empty($bearer_token)) {
            return $this->unauthorizedResponse();
        }
        $Usuario = Usuario::where("rememberToken",$token)
        ->where("statusToken",1)
        ->first();   
        if ($Usuario !== null) {    
                $secret_key = $Usuario->secret_key;
                $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));    
                return $handler->handle($request);
        }   
        else{
                return $this->unauthorizedResponse();     
        }
    }

    private function unauthorizedResponse(): Response
    {
        $response = new Response();
        $response->getBody()->write('Acceso no autorizado');
        return $response->withStatus(401);
    }
}