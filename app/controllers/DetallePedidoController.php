<?php
require_once './models/DetallePedido.php';

class DetallePedidoController extends DetallePedido
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $id_pedido           = $parametros['id_pedido'];
        $id_menu             = $parametros['id_menu'];
        $cantidad            = $parametros['cantidad'];
        $usr = new DetallePedido();
       
        $usr->id_pedido = $id_pedido;
        $usr->id_menu = $id_menu;
        $usr->cantidad = $cantidad;
        $numeroPedido = $usr->crearDetalle();
        $payload = json_encode(array("mensaje" => "Detalle ".$id_pedido." creado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    
    
    public function cargarTablaDesdeCSV($request,$response,$args)
    {
        $uno = new DetallePedido();
        $uno->cargarTablasDesdeCSV();

        $payload = json_encode(array("mensaje" => "Tabla Detalle cargada exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarCSVdesdeTabla($request,$response,$args)
    {
        $uno = new DetallePedido();
        $uno->cargarCSVdesdeTablas();

        $payload = json_encode(array("mensaje" => "Tabla Detalle bajada completa a CSV exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }


    public function TraerUno($request, $response, $args)
    {

        $id_pedido = $args['id_pedido'];
        $lista = DetallePedido::obtenerDetalle($id_pedido);
        $payload = json_encode(array("listaDetalle" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = DetallePedido::obtenerTodos();
        $payload = json_encode(array("listaDetalle" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $id_pedido          = $parametros['id_pedido'];
        $id_menu            = $parametros['id_menu'];
        $DetallePedido = DetallePedido::obtenerDetallePorPedidoYMenu($id_pedido,$id_menu);
        $cantidad           = $parametros['cantidad'];
        $DetallePedido->cantidad  = $cantidad;
        DetallePedido::modificarDetalle($DetallePedido);

        $payload = json_encode(array("mensaje" => "Detalle ".$id_pedido." ".$id_menu." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $id_pedido = $args['id_pedido'];
        $id_menu = $args['id_menu'];

        DetallePedido::borrarDetalle($id_pedido,$id_menu);
        $payload = json_encode(array("mensaje" => "Detalle ".$id_pedido." ".$id_menu." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}