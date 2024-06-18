<?php
require_once './models/Menu.php';

class MenuController extends Menu
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $nombre              = $parametros['nombre'];
        $precio              = $parametros['precio'];
        $demora              = $parametros['demora'];
        $usr = new Menu();
        $usr->precio = $precio;
        $usr->nombre = $nombre;
        $usr->demora = $demora;
        $usr->crearMenu();
        $payload = json_encode(array("mensaje" => "Menu creado exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    
    public function cargarTablaDesdeCSV($request,$response,$args)
    {
        $uno = new Menu();
        $uno->cargarTablasDesdeCSV();

        $payload = json_encode(array("mensaje" => "Tabla Menu cargada exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarCSVdesdeTabla($request,$response,$args)
    {
        $uno = new Menu();
        $uno->cargarCSVdesdeTablas();

        $payload = json_encode(array("mensaje" => "Tabla Menu bajada completa a CSV exitosamente"));

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

    public function TraerPorNumero($request, $response, $args)
    {
        // Buscamos Menu numero
        $usr = $args['numero'];
        $Menu = Menu::obtenerMenuPorNumero($usr);
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
        $precio     = $parametros['precio'];
        $demora     = $parametros['demora'];
        $precio     = $parametros['precio'];
        $demora     = $parametros['demora'];
        $Menu->demora = $demora;
        $Menu->precio = $precio;
        
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


    public function ModificarPorNumero($request, $response, $args)
    {

        $parametros = $request->getParsedBody();
        $numero     = $parametros['numero'];
        $Menu = Menu::obtenerMenuPorNumero($numero);
        $nombre     = $parametros['nombre'];
        $precio     = $parametros['precio'];
        $demora     = $parametros['demora'];
        $Menu->nombre = $nombre;
        $Menu->demora = $demora;
        $Menu->precio = $precio;
        
        Menu::modificarMenu($Menu);

        $payload = json_encode(array("mensaje" => "Menu ".$nombre." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}