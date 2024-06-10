<?php

class Usuario
{
    public $id_usuario;
    public $nombre;
    public $apellido;
    public $mail;
    //public $estado;// dak forzil
    //public $id_pedido;// dak forzil
    public $rol;
    public $activo;



    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario (nombre,apellido,mail,rol,activo) VALUES (:nombre,:apellido,:mail,:rol,1)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_usuario,nombre,apellido,mail,rol,activo FROM usuario WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($nombre,$apellido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_usuario,nombre,apellido,mail,rol,activo FROM usuario WHERE nombre = :nombre and apellido = :apellido");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function modificarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET nombre = :nombre, apellido = :apellido,mail = :mail,rol = :rol WHERE id_usuario = :id");
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $usuario->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $usuario->mail, PDO::PARAM_INT);
        $consulta->bindValue(':rol', $usuario->rol, PDO::PARAM_STR);
        $consulta->bindValue(':id', $usuario->id_usuario, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarUsuario($nombre,$apellido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuario SET activo = 0 WHERE nombre = :nombre and apellido = :apellido");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->execute();
    }

}