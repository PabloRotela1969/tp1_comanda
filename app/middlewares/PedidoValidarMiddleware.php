<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class PedidoValidarMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $mensaje = "";
        $parametros = $request->getParsedBody();
        if(isset($parametros["id_pedido"]) && $parametros["estado_pedido"])
        {
            $id_pedido = $parametros['id_pedido'];
            $nuevo_estado = $parametros['estado_pedido'];
            if($nuevo_estado == "pendiente" || $nuevo_estado == "en preparacion" || $nuevo_estado == "listo para servir")
            {
                $response = $handler->handle($request);
            }
            else
            {
                $mensaje = "Favor de elegir entre PENDIENTE, EN PREPARACION y LISTO PARA SERVIR";
                $response = new Response();
                $payload = json_encode($mensaje);
                $response->getBody()->write($payload);
                $response->withHeader('Content-Type', 'application/json');
            }
        }
        else
        {
            $mensaje = "Favor de ingresar el ID del pedido y el estado";
            $response = new Response();
            $payload = json_encode($mensaje);
            $response->getBody()->write($payload);
            $response->withHeader('Content-Type', 'application/json');
        }
        return $response;
    }
}