<?php

class Pedido
{
    public $id_pedido;
    public $estado_pedido;
    public $id_menu;
    public $tiempoEstimado;
    public $id_mesa;
    public $activo;
    public $fecha;
    public $id_usuario;
    public $foto;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO Pedido (estado_pedido,id_menu,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto) VALUES (:estado_pedido,:id_menu,:tiempoEstimado,:id_mesa,1,:fecha,:id_usuario,:foto)");
        $consulta->bindValue(':estado_pedido', $this->estado_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':id_menu', $this->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoEstimado', $this->tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,estado_pedido,id_menu,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto FROM Pedido WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,estado_pedido,id_menu,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto  FROM Pedido WHERE id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Pedido SET estado_pedido = :estado_pedido, id_menu = :id_menu, tiempoEstimado = :tiempoEstimado , id_mesa = :id_mesa, fecha = :fecha,id_usuario = :id_usuario, foto = :foto WHERE id_pedido = :id");
        $consulta->bindValue(':estado_pedido', $Pedido->estado_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':id_menu', $Pedido->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoEstimado', $Pedido->tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $Pedido->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $Pedido->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $Pedido->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $Pedido->foto, PDO::PARAM_STR);
        $consulta->bindValue(':id', $Pedido->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Pedido SET activo = 0 WHERE id_pedido = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

}