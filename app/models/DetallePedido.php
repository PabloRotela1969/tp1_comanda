<?php
class DetallePedido
{
    public $id_pedido;
    public $id_menu;
    public $cantidad;
    public $activo;

    public function crearDetalle()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO Detalle (id_pedido,id_menu,cantidad,activo) VALUES (:id_pedido,:id_menu,:cantidad,1)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':id_menu', $this->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function cargarTablasDesdeCSV()
    {
        $array = archivos::LeerArchivo('./data/detallesPedidos.csv');
        foreach ($array as $linea)
        {
            $dato = explode(',',$linea);
            if(isset($dato[1]))
            {
                $this->id_pedido             = $dato[0];
                $this->id_menu               = $dato[1];
                $this->cantidad              = $dato[2];
                $this->cantidad                = $dato[3];
                $this->crearDetalle();

            }
        }
    }

    public function cargarCSVdesdeTablas()
    {
        $array = self::obtenerTodos();
        foreach($array as $linea)
        {
            $cadena = $linea->id_pedido.",".$linea->id_menu.",".$linea->cantidad.",".$linea->activo."\n";
            archivos::escribirCadenaHaciaArchivo('./data/detallesPedidosBajados.csv',$cadena);
        }
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,activo FROM Detalle WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    public static function obtenerDetalle($id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,activo  FROM Detalle WHERE id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    public static function obtenerDetallePorPedidoYMenu($id_pedido,$id_menu)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,activo  FROM Detalle WHERE id_pedido = :id_pedido and id_menu = :id_menu");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('DetallePedido');
     
    }


    public static function modificarDetalle($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Detalle SET cantidad = :cantidad WHERE id_pedido = :id_pedido and id_menu = :id_menu");
        $consulta->bindValue(':id_pedido', $Pedido->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_menu', $Pedido->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $Pedido->cantidad, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarDetalle($id_pedido,$id_menu)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Detalle SET activo = 0 WHERE id_pedido = :id_pedido and id_menu = :id_menu");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
        $consulta->execute();
    }

}