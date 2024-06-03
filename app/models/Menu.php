<?php

class Menu
{
    public $id_menu;
    public $nombre;
    public $tiempoPreparado;
    public $activo;


    public function crearMenu()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre,tiempoPreparado,activo) VALUES (:nombre,:tiempoPreparado,1)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoPreparado', $this->tiempoPreparado, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_menu,nombre,tiempoPreparado,activo FROM menu WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Menu');
    }

    public static function obtenerMenu($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_menu,nombre,tiempoPreparado,activo FROM menu WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchObject('Menu');
    }

    public static function modificarMenu($menu)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE menu SET nombre = :nombre, tiempoPreparado = :tiempoPreparado WHERE id_menu = :id");
        $consulta->bindValue(':nombre', $menu->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoPreparado', $menu->tiempoPreparado, PDO::PARAM_INT);
        $consulta->bindValue(':id', $menu->id_menu, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarMenu($menu)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE menu SET activo = 0 WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $menu, PDO::PARAM_STR);
        $consulta->execute();
    }

}