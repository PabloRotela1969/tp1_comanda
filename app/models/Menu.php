<?php

class Menu
{
    public $id_menu;
    public $nombre;
    public $precio;
    public $sector;
    public $activo;


    public function crearMenu()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre,precio,sector,activo) VALUES (:nombre,:precio,:sector,1)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function cargarTablasDesdeCSV()
    {
        $array = archivos::LeerArchivo('./data/menues.csv');
        foreach ($array as $linea)
        {
            $dato = explode(',',$linea);
            if(isset($dato[1]))
            {
                $this->id_menu              = $dato[0];
                $this->nombre               = $dato[1];
                $this->precio               = $dato[2];
                $this->sector               = $dato[3];
                $this->activo               = $dato[4];
                $this->crearMenu();

            }
        }
    }

    public function cargarCSVdesdeTablas()
    {
        $array = self::obtenerTodos();
        foreach($array as $linea)
        {
            $cadena = $linea->id_menu.",".$linea->nombre.",".$linea->precio.",".$linea->sector.",".$linea->activo."\n";
            archivos::escribirCadenaHaciaArchivo('./data/menuesBajados.csv',$cadena);
        }
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_menu,nombre,precio,sector,activo FROM menu WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Menu');
    }

    public static function obtenerMenu($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_menu,nombre,precio,sector,activo FROM menu WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchObject('Menu');
    }

    public static function obtenerMenuPorNumero($numero)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_menu,nombre,precio,sector,activo FROM menu WHERE id_menu = :id");
        $consulta->bindValue(':id', $numero, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Menu');
    }

    public static function modificarMenu($menu)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE menu SET nombre = :nombre, precio = :precio, sector = :sector WHERE id_menu = :id");
        $consulta->bindValue(':nombre', $menu->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $menu->precio, PDO::PARAM_STR);
        $consulta->bindValue(':sector', $menu->sector, PDO::PARAM_STR);
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

    public static function borrarMenuPorNumero($id_menu)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE menu SET activo = 0 WHERE id_menu = :id_menu");
        $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
        $consulta->execute();
    }

}