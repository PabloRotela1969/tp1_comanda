<?php
require_once './models/Mesa.php';

class MesaController extends Mesa
{
    public function CargarUno($request,$response,$args)
    {
        $parametros          = $request->getParsedBody();
        $estado_mesa         = $parametros['estado_mesa'];
        $importe             = $parametros['importe'];
        $fecha               = $parametros['fecha'];
        $tipoComentario      = $parametros['tipoComentario'];
        $comentario          = $parametros['comentario'];
        $foto                = $parametros['foto'];

        $usr = new Mesa();
        
        $usr->estado_mesa = $estado_mesa;
        $usr->importe = $importe;
        $usr->fecha = $fecha;
        $usr->tipoComentario = $tipoComentario;
        $usr->comentario = $comentario;
        $usr->foto = $foto;
        $numeroMesa = $usr->crearMesa();
        $payload = json_encode(array("mensaje" => "Mesa ".$numeroMesa." creado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

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
        $importe                = $parametros['importe'];
        $fecha                  = $parametros['fecha'];
        $tipoComentario         = $parametros['tipoComentario'];
        $comentario             = $parametros['comentario'];
        $foto                   = $parametros['foto'];
        $Mesa->estado_mesa = $estado_mesa;
        $Mesa->importe = $importe;
        $Mesa->fecha = $fecha;
        $Mesa->tipoComentario = $tipoComentario;
        $Mesa->comentario = $comentario;
        $Mesa->foto = $foto;

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