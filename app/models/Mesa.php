<?php

class Mesa
{
    public $id_mesa;
    public $estado_mesa;
    public $importe;
    public $fecha;
    public $tipoComentario;
    public $comentario;
    public $foto;
    public $activo;


    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesa (estado_mesa,importe,fecha,tipoComentario,comentario,foto,activo) VALUES (:estado_mesa,:importe,:fecha,:tipoComentario,:comentario,:foto,1)");
        $consulta->bindValue(':estado_mesa', $this->estado_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha,  PDO::PARAM_STR);
        $consulta->bindValue(':tipoComentario', $this->tipoComentario, PDO::PARAM_STR);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_mesa,estado_mesa,importe,fecha,tipoComentario,comentario,foto,activo FROM Mesa WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_mesa,estado_mesa,importe,fecha,tipoComentario,comentario,foto,activo  FROM Mesa WHERE id_mesa = :id_mesa");
        $consulta->bindValue(':id_mesa', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Mesa');
    }

    public static function modificarMesa($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Mesa SET estado_mesa = :estado_mesa, importe = :importe, fecha = :fecha , tipoComentario = :tipoComentario , comentario = :comentario, foto = :foto WHERE id_mesa = :id");
        $consulta->bindValue(':estado_mesa', $Pedido->estado_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $Pedido->importe, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $Pedido->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':tipoComentario', $Pedido->tipoComentario, PDO::PARAM_STR);
        $consulta->bindValue(':comentario', $Pedido->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $Pedido->foto, PDO::PARAM_STR);
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