<?php
require_once './models/Usuario.php';

class UsuarioController extends Usuario
{
    public function CargarUno($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $apellido   = $parametros['apellido'];
        $mail       = $parametros['mail'];
        $rol        = $parametros['rol'];
        $usr = new Usuario();
        
        $usr->nombre = $nombre;
        $usr->apellido = $apellido;
        $usr->mail = $mail;
        $usr->rol = $rol;
        $usr->crearUsuario();
        $payload = json_encode(array("mensaje" => "Usuario creado exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $nombre = $args['nombre'];
        $apellido = $args['apellido'];
        $usuario = Usuario::obtenerUsuario($nombre,$apellido);
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
        $apellido   = $parametros['apellido'];
        $usuario    = Usuario::obtenerUsuario($nombre,$apellido);
        $mail       = $parametros['mail'];
        $rol        = $parametros['rol'];
        $usuario->apellido = $apellido;
        $usuario->mail = $mail;
        $usuario->rol = $rol;
        Usuario::modificarUsuario($usuario);

        $payload = json_encode(array("mensaje" => "Usuario ".$nombre." ".$apellido." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $nombre = $args['nombre'];
        $apellido = $args['apellido'];

        Usuario::borrarUsuario($nombre,$apellido);
        $payload = json_encode(array("mensaje" => "Usuario ".$nombre." ".$apellido." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}