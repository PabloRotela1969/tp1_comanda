<?php
require_once './models/Mesa.php';

class MesaController extends Mesa
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $estado_mesa         = $parametros['estado_mesa'];
        $tipoComentario      = $parametros['tipoComentario'];
        $comentario          = $parametros['comentario'];

        $usr = new Mesa();
        
        $usr->estado_mesa = $estado_mesa;
        $usr->tipoComentario = $tipoComentario;
        $usr->comentario = $comentario;
        $numeroMesa = $usr->crearMesa();
        $payload = json_encode(array("mensaje" => "Mesa ".$numeroMesa." creado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    
    public function cargarTablaDesdeCSV($request,$response,$args)
    {
        $uno = new Mesa();
        $uno->cargarTablasDesdeCSV();

        $payload = json_encode(array("mensaje" => "Tabla Mesa cargada exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarCSVdesdeTabla($request,$response,$args)
    {
        $lista = Mesa::obtenerTodos(); // Obtén los datos de la base de datos
        $csvContent = "id_mesa,estado_mesa,tipoComentario,comentario,activo\n"; // Encabezado CSV
        foreach ($lista as $mesa) 
        {
            $csvContent .= $mesa->id_mesa.",".$mesa->estado_mesa.",".$mesa->tipoComentario.",".$mesa->comentario.",".$mesa->activo."\n";
        }
        $response->getBody()->write($csvContent);
        return $response->withHeader('Content-Type', 'text/csv');
    }


    public function TraerUno($request, $response, $args)
    {
        // Buscamos Mesa por nombre
        $usr = $args['id_mesa'];
        $Mesa = Mesa::obtenerMesa($usr);
        $payload = json_encode($Mesa);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesa" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $id_Mesa     = $parametros['id_mesa'];
        $Mesa = Mesa::obtenerMesa($id_Mesa);
        $estado_mesa            = $parametros['estado_mesa'];
        $tipoComentario         = $parametros['tipoComentario'];
        $comentario             = $parametros['comentario'];
        $Mesa->estado_mesa = $estado_mesa;
        $Mesa->tipoComentario = $tipoComentario;
        $Mesa->comentario = $comentario;

        Mesa::modificarMesa($Mesa);

        $payload = json_encode(array("mensaje" => "Mesa ".$id_Mesa." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $usr = $args['id_mesa'];

        Mesa::borrarMesa($usr);
        $payload = json_encode(array("mensaje" => "Mesa ".$usr." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}