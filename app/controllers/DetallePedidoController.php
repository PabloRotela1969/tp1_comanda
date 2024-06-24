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
        $estado_detalle      = $parametros['estado_detalle'];
        $id_usuario          = $parametros['id_usuario'];
        $demora              = $parametros['demora'];
        $usr = new DetallePedido();
       
        $usr->id_pedido = $id_pedido;
        $usr->id_menu = $id_menu;
        $usr->cantidad = $cantidad;
        $usr->estado_detalle = $estado_detalle;
        $usr->id_usuario = $id_usuario;
        $usr->demora = $demora;
        $numeroPedido = $usr->crearDetalle();
        $payload = json_encode(array("mensaje" => "Detalle ".$id_pedido.",".$id_menu." creado exitosamente"));
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
        $lista = DetallePedido::obtenerTodos(); // Obtén los datos de la base de datos
        $csvContent = "id_pedido,id_menu,cantidad,estado_detalle,id_usuario,demora,activo\n"; // Encabezado CSV
        foreach ($lista as $detalle) 
        {
            $csvContent .= $detalle->id_pedido.",".$detalle->id_menu.",".$detalle->cantidad.",".$detalle->estado_detalle.",".$detalle->id_usuario.",".$detalle->demora.",".$detalle->activo."\n";
        }
        $response->getBody()->write($csvContent);
        return $response->withHeader('Content-Type', 'text/csv');
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
        $estado_detalle     = $parametros['estado_detalle'];
        $id_usuario         = $parametros['id_usuario'];
        $demora             = $parametros['demora'];
        $DetallePedido->cantidad  = $cantidad;
        $DetallePedido->estado_detalle = $estado_detalle;
        $DetallePedido->id_usuario = $id_usuario;
        $DetallePedido->demora = $demora;
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