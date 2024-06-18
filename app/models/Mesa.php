<?php

class Mesa
{
    public $id_mesa;
    public $estado_mesa;
    public $tipoComentario;
    public $comentario;
    public $activo;


    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesa (estado_mesa,tipoComentario,comentario,activo) VALUES (:estado_mesa,:tipoComentario,:comentario,1)");
        $consulta->bindValue(':estado_mesa', $this->estado_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':tipoComentario', $this->tipoComentario, PDO::PARAM_STR);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function cargarTablasDesdeCSV()
    {
        $array = archivos::LeerArchivo('./data/mesas.csv');
        foreach ($array as $linea)
        {
            $dato = explode(',',$linea);
            if(isset($dato[1]))
            {
                $this->id_mesa              = $dato[0];
                $this->estado_mesa          = $dato[1];
                $this->tipoComentario       = $dato[2];
                $this->comentario           = $dato[3];
                $this->crearMesa();

            }
        }
    }

    public function cargarCSVdesdeTablas()
    {
        $array = self::obtenerTodos();
        foreach($array as $linea)
        {
            $cadena = $linea->id_mesa.",".$linea->estado_mesa.",".$linea->tipoComentario.",".$linea->comentario."\n";
            archivos::escribirCadenaHaciaArchivo('./data/mesasBajados.csv',$cadena);
        }
    }


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_mesa,estado_mesa,tipoComentario,comentario,activo FROM Mesa WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_mesa,estado_mesa,tipoComentario,comentario,activo  FROM Mesa WHERE id_mesa = :id_mesa");
        $consulta->bindValue(':id_mesa', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Mesa');
    }

    public static function modificarMesa($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Mesa SET estado_mesa = :estado_mesa, tipoComentario = :tipoComentario , comentario = :comentario WHERE id_mesa = :id");
        $consulta->bindValue(':estado_mesa', $Pedido->estado_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':tipoComentario', $Pedido->tipoComentario, PDO::PARAM_STR);
        $consulta->bindValue(':comentario', $Pedido->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':id', $Pedido->id_mesa, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarMesa($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Mesa SET activo = 0 WHERE id_mesa = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

}