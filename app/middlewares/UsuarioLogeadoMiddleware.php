<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UsuarioLogeadoMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $mensaje = "";
        $parametros = $request->getParsedBody();
        if(isset($parametros["rol"]))
        {
            $rol = $parametros["rol"];
            if($rol == "admin" || $rol == "socio" || $rol == "cocinero" || $rol == "bartender")
            {
                $response = $handler->handle($request);
            }
            else
            {
                $mensaje = "Favor de definir el rol como admin, socio, cocinero o bartender, sólo de esos tipos";
            }
        }
        else
        {
            $mensaje = "No se definió el rol";
        }
        $response = new Response();
        $payload = json_encode($mensaje);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}