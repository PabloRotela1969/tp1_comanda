<?php
require_once './models/Pedido.php';

class PedidoController extends Pedido
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $estado_pedido       = $parametros['estado_pedido'];
        $tiempoEstimado      = $parametros['tiempoEstimado'];
        $id_mesa             = $parametros['id_mesa'];
        $fecha               = $parametros['fecha'];
        $id_usuario          = $parametros['id_usuario'];
        $foto                = $parametros['foto'];

        $usr = new Pedido();
        
        $usr->estado_pedido = $estado_pedido;
        $usr->tiempoEstimado = $tiempoEstimado;
        $usr->id_mesa = $id_mesa;
        $usr->fecha = $fecha;
        $usr->id_usuario = $id_usuario;
        $usr->foto = $foto;
        $numeroPedido = $usr->crearPedido();
        $payload = json_encode(array("mensaje" => "Pedido ".$numeroPedido." creado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }


    public function cargarTablaDesdeCSV($request,$response,$args)
    {
        $uno = new Pedido();
        $uno->cargarTablasDesdeCSV();

        $payload = json_encode(array("mensaje" => "Tabla Pedido cargada exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarCSVdesdeTabla($request,$response,$args)
    {
        $uno = new Pedido();
        $uno->cargarCSVdesdeTablas();

        $payload = json_encode(array("mensaje" => "Tabla Pedido bajada completa a CSV exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }


    public function TraerUno($request, $response, $args)
    {
        // Buscamos Pedido por nombre
        $usr = $args['pedido'];
        $Pedido = Pedido::obtenerPedido($usr);
        $payload = json_encode($Pedido);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $id_pedido     = $parametros['id_pedido'];
        $Pedido = Pedido::obtenerPedido($id_pedido);
        $estado              = $parametros['estado_pedido'];
        $tiempoEstimado      = $parametros['tiempoEstimado'];
        $id_mesa             = $parametros['id_mesa'];
        $fecha               = $parametros['fecha'];
        $id_usuario          = $parametros['id_usuario'];
        $foto                = $parametros['foto'];
        
        $Pedido->estado_pedido = $estado;
        $Pedido->tiempoEstimado = $tiempoEstimado;
        $Pedido->id_mesa = $id_mesa;
        $Pedido->fecha = $fecha;
        $Pedido->id_usuario = $id_usuario;
        $Pedido->foto = $foto;
        Pedido::modificarPedido($Pedido);

        $payload = json_encode(array("mensaje" => "Pedido ".$id_pedido." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function CambiarEstado($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id_pedido     = $parametros['id_pedido'];
        $nuevo_estado = $parametros['estado_pedido'];

        if(Pedido::obtenerPedido($id_pedido) != null)
        {
            $Pedido = Pedido::obtenerPedido($id_pedido);
            $viejo_estado = $Pedido->estado_pedido;
            $Pedido->estado_pedido = $nuevo_estado;
            Pedido::modificarPedido($Pedido);
            $payload = json_encode(array("mensaje" => "Pedido ".$id_pedido." se cambió de ".$viejo_estado." a ".$nuevo_estado));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "NO SE ENCONTRÓ EL Pedido ".$id_pedido));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function BorrarUno($request, $response, $args)
    {
        $usr = $args['id_pedido'];

        Pedido::borrarPedido($usr);
        $payload = json_encode(array("mensaje" => "Pedido ".$usr." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}