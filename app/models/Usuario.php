<?php

class Usuario
{
    public $id_usuario;
    public $nombre;
    public $estado;
    public $id_pedido;
    public $rol;



    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario (nombre,estado,id_pedido,rol,activo) VALUES (:nombre,:estado,:id_pedido,:rol,1)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_usuario,nombre,estado,id_pedido,rol FROM usuario WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_usuario,nombre,estado,id_pedido,rol FROM usuario WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function modificarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET nombre = :nombre, estado = :estado,id_pedido = :id_pedido,rol = :rol WHERE id_usuario = :id");
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $usuario->estado, PDO::PARAM_STR);
        $consulta->bindValue(':id_pedido', $usuario->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':rol', $usuario->rol, PDO::PARAM_STR);
        $consulta->bindValue(':id', $usuario->id_usuario, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET activo = 0 WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $usuario, PDO::PARAM_STR);
        $consulta->execute();
    }

}