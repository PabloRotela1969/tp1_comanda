<?php
require_once './models/Usuario.php';

class UsuarioController extends Usuario
{
    public function CargarUno($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $estado     = $parametros['estado'];
        $id_pedido  = $parametros['id_pedido'];
        $rol        = $parametros['rol'];
        $usr = new Usuario();
        
        $usr->nombre = $nombre;
        $usr->estado = $estado;
        $usr->id_pedido = $id_pedido;
        $usr->rol = $rol;
        $usr->crearUsuario();
        $payload = json_encode(array("mensaje" => "Usuario creado exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $usuario = Usuario::obtenerUsuario($nombre);
        $estado     = $parametros['estado'];
        $id_pedido  = $parametros['id_pedido'];
        $rol        = $parametros['rol'];
        $usuario->estado = $estado;
        $usuario->id_pedido = $id_pedido;
        $usuario->rol = $rol;
        Usuario::modificarUsuario($usuario);

        $payload = json_encode(array("mensaje" => "Usuario ".$nombre." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $usr = $args['usuario'];

        Usuario::borrarUsuario($usr);
        $payload = json_encode(array("mensaje" => "Usuario ".$usr." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}