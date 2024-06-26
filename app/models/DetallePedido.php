<?php
class DetallePedido
{
    public $id_pedido;
    public $id_menu;
    public $cantidad;
    public $estado_detalle;
    public $id_usuario;
    public $demora;
    public $activo;

    public function crearDetalle()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO Detalle (id_pedido,id_menu,cantidad,estado_detalle,id_usuario,demora,activo) VALUES (:id_pedido,:id_menu,:cantidad,:estado_detalle,:id_usuario,:demora,1)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':id_menu', $this->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado_detalle', $this->estado_detalle, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':demora', $this->demora, PDO::PARAM_INT);
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
                $this->estado_detalle        = $dato[3];
                $this->id_usuario            = $dato[4];
                $this->demora                = $dato[5];
                $this->activo                = $dato[6];
                $this->crearDetalle();

            }
        }
    }

    public function cargarCSVdesdeTablas()
    {
        $array = self::obtenerTodos();
        foreach($array as $linea)
        {
            $cadena = $linea->id_pedido.",".$linea->id_menu.",".$linea->cantidad.",".$linea->estado_detalle.",".$linea->id_usuario.",".$linea->demora.",".$linea->activo."\n";
            archivos::escribirCadenaHaciaArchivo('./data/detallesPedidosBajados.csv',$cadena);
        }
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,estado_detalle,id_usuario,demora,activo FROM Detalle WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    public static function obtenerDetalle($id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,estado_detalle,id_usuario,demora,activo FROM Detalle WHERE id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'DetallePedido');
    }

    public static function obtenerDetallePorPedidoYMenu($id_pedido,$id_menu)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,id_menu,cantidad,estado_detalle,id_usuario,demora,activo  FROM Detalle WHERE id_pedido = :id_pedido and id_menu = :id_menu");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_menu', $id_menu, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('DetallePedido');
     
    }


    public static function modificarDetalle($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Detalle SET cantidad = :cantidad , estado_detalle = :estado_detalle , id_usuario = :id_usuario, demora = :demora WHERE id_pedido = :id_pedido and id_menu = :id_menu");
        $consulta->bindValue(':id_pedido', $Pedido->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_menu', $Pedido->id_menu, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $Pedido->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado_detalle', $Pedido->estado_detalle, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $Pedido->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':demora', $Pedido->demora, PDO::PARAM_INT);
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