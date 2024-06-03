<?php
require_once './models/Menu.php';

class MenuController extends Menu
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $nombre              = $parametros['nombre'];
        $tiempoPreparado     = $parametros['tiempoPreparado'];
        $usr = new Menu();
        
        $usr->nombre = $nombre;
        $usr->tiempoPreparado = $tiempoPreparado;
        $usr->crearMenu();
        $payload = json_encode(array("mensaje" => "Menu creado exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos Menu por nombre
        $usr = $args['menu'];
        $Menu = Menu::obtenerMenu($usr);
        $payload = json_encode($Menu);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Menu::obtenerTodos();
        $payload = json_encode(array("listaMenu" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $Menu = Menu::obtenerMenu($nombre);
        $tiempoPreparado     = $parametros['tiempoPreparado'];
        $Menu->tiempoPreparado = $tiempoPreparado;
        Menu::modificarMenu($Menu);

        $payload = json_encode(array("mensaje" => "Menu ".$nombre." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $usr = $args['menu'];

        Menu::borrarMenu($usr);
        $payload = json_encode(array("mensaje" => "Menu ".$usr." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}